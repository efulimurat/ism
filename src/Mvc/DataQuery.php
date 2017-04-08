<?php

namespace Mvc;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Mvc\CacheComponent;
use Doctrine\ORM\Query\ResultSetMapping;

class DataQuery {

    private static $em;
    private $query;
    private $t_alias;
    private $q_from;
    public $cacheKey;
    public $cacheTimeout;
    private $caller_controller;
    private $caller_method;
    protected $user_id;

    public static function createEM($db, $conf) {
        self::$em = EntityManager::create($db, $conf);
    }

    public static function getEM() {
        return self::$em;
    }

    function __construct() {
        $debug = debug_backtrace();

        $this->caller_controller = str_replace("App\Controllers\\", "", $debug[1]["class"]);
        $this->caller_method = $debug[1]["function"];

        $user_id = \Mvc\Authenticate::getAuthUser();
        if ($user_id) {
            $this->user_id = $user_id;
        }
    }

    private function initQuery($entity = null) {
        if ($entity != null) {
            $this->t_alias = $entity . "_als";
            $entity = "App\\Entity\\" . $entity;
            $this->q_from = $entity;
        }
        CacheComponent::addKey("Title", $this->cacheKey);
        CacheComponent::addKey("Controller", $this->caller_controller);
        CacheComponent::addKey("Method", $this->caller_method);
    }

    private function flushQuery() {
        self::$em->flush();
    }

    protected function createQuery($entity) {
        $em = self::getEM();
        $this->initQuery($entity);

        $this->query = $em->createQueryBuilder()
                        ->select($this->t_alias)->from($this->q_from, $this->t_alias);

        return $this;
    }

    protected function createRawQuery($sql) {
        $em = self::getEM();
        $this->initQuery();

        $rsm = new ResultSetMapping();
        $this->query = $em->createNativeQuery($sql, $rsm);

        return $this;
    }

    protected function createInsert($entity) {
        $em = self::getEM();
        $em->persist($entity);
        $this->flushQuery();
        return $entity;
    }

    protected function createUpdate($entity) {
        $em = self::getEM();
        $em->merge($entity);
        $this->flushQuery();
        return $entity;
    }

    protected function deleteRecord($entity) {
        $em = self::getEM();
        $this->initQuery($entity);

        $this->query = $em->createQueryBuilder()
                ->delete($this->q_from, $this->t_alias);

        return $this;
    }

    protected function createRepo($entity) {
        $em = self::getEM();
        $this->initQuery($entity);

        $this->query = $em->getRepository('App\Entity\\' . $entity);

        return $this;
    }

    protected function limit($start, $length = 10) {
        $this->query = $this->query
                ->setFirstResult($start)
                ->setMaxResults($length);

        CacheComponent::addKey("LimitStart", $start);
        CacheComponent::addKey("LimitLength", $length);

        return $this;
    }

    protected function order($orderBy, $orderDir = " asc") {
        $this->query = $this->query
                ->orderBy($this->t_alias . "." . $orderBy, $orderDir);

        CacheComponent::addKey("OrderBy", $orderBy);
        CacheComponent::addKey("OrderDir", $orderDir);

        return $this;
    }

    protected function whereStatus($status = 1) {
        $this->query = $this->query
                ->where($this->t_alias . ".status = " . $status);

        CacheComponent::addKey("Status", $status);
        return $this;
    }

    protected function whereUserId($user_id) {
        $this->query = $this->query
                ->where($this->t_alias . ".user_id = " . $user_id);

        return $this;
    }

    protected function whereIssueId($issue_id) {

        $this->query = $this->query
                ->where($this->t_alias . ".issue_id = " . $issue_id);

        return $this;
    }

    protected function whereIn($col, $arr) {
        if (!empty($arr)) {
            $imp = "'" . implode("','", $arr) . "'";

            $this->query = $this->query
                    ->where($this->t_alias . "." . $col . " IN (" . $imp . ")");
        }
        return $this;
    }

    protected function paginate($query, $fetchJoinCollection = true) {
        return new Paginator($this->query, $fetchJoinCollection);
    }

    protected function getResultSet($paginate = true, $rawQuery = false) {

        $cacheTimeout = $this->cacheTimeout;
        $cacheKey = CacheComponent::getKey();
        $this->flushCacheInput();
        if ($cacheData = CacheComponent::get($cacheKey)) {
            return $cacheData;
        } else {
            $query = $this->query;
            if ($rawQuery == true) {
                $data = $query->getResult();
            } else {
                $data = $query->getQuery()->getArrayResult();
            }

            $result = [];
            if (!empty($data)) {
                if ($paginate == true) {
                    $dataPg = $this->paginate($query);
                    $countResults = count($dataPg);
                    $result["total_count"] = $countResults;
                    $result["data"] = $data;
                } else {
                    $result = $data;
                }

                CacheComponent::set($cacheKey, $result, $cacheTimeout);
            }
            $this->flushQuery();
            return $result;
        }
    }

    protected function executeQuery() {
        $query = $this->query;
        $query->getQuery()->getResult();
        return true;
    }

    protected function rawResults($paginate = true) {
        return $this->getResultSet($paginate, true);
    }

    protected function findResult($input) {

        $cacheTimeout = $this->cacheTimeout;
        $cacheKey = CacheComponent::getKey();
        $this->flushCacheInput();
        if ($cacheData = CacheComponent::get($cacheKey)) {
            return $cacheData;
        } else {
            $query = $this->query;
            $data = $query->findOneBy($input);
            if (!empty($data)) {
                CacheComponent::set($cacheKey, $data, $cacheTimeout);
            }
            $this->flushQuery();
            return $data;
        }
    }

    private function flushCacheInput() {
        $this->cacheKey = "";
        $this->cacheTimeout = 0;
    }

}
