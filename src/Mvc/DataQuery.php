<?php

namespace Mvc;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Mvc\CacheComponent;

class DataQuery {

    private static $em;
    private $query;
    private $t_alias;
    private $q_from;
    public $cacheKey;
    public $cacheTimeout;
    private $caller_controller;
    private $caller_method;

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
    }

    private function initQuery($entity) {
        $this->t_alias = $entity . "_als";
        $entity = "App\\Entity\\" . $entity;
        $this->q_from = $entity;

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

    protected function createInsert($entity) {
        $em = self::getEM();
        $em->persist($entity);
        $this->flushQuery();
        return $entity;
    }

    protected function createRepo($entity) {
        $em = self::getEM();
        $this->initQuery($entity);

        $this->query = $em->getRepository('App\Entity\\' . $entity);

        return $this;
    }

    protected function limit(
    $start, $length = 10) {
        $this->query = $this->query
                ->setFirstResult($start)
                ->setMaxResults($length);

        CacheComponent::addKey("LimitStart", $start);
        CacheComponent::addKey("LimitLength", $length);

        return $this;
    }

    protected function order(
    $orderBy, $orderDir = " asc") {
        $this->query = $this->query
                ->orderBy($this->t_alias . "." . $orderBy, $orderDir);

        CacheComponent::addKey("OrderBy", $orderBy);
        CacheComponent::addKey("OrderDir", $orderDir);

        return $this;
    }

    protected function paginate($query, $fetchJoinCollection = true) {
        return new Paginator($this->query, $fetchJoinCollection);
    }

    protected function getResultSet($paginate = true) {

        $cacheTimeout = $this->cacheTimeout;
        $cacheKey = CacheComponent::getKey();
        $this->flushCacheInput();
        if ($cacheData = CacheComponent::get($cacheKey)) {
            return $cacheData;
        } else {
            $query = $this->query;
            $data = $query->getQuery()->getArrayResult();
           
            $result = [];
            if ($paginate == true) {
                $dataPg = $this->paginate($query);
                $countResults = count($dataPg); 
                $result["total_count"] = $countResults;
                $result["data"] = $data;
            } else {
                $result = $data;
            }

            CacheComponent::set($cacheKey, $result, $cacheTimeout);
            $this->flushQuery();
            return $result;
        }
    }

    protected function findResult($identifier) {

        $cacheTimeout = $this->cacheTimeout;
        $cacheKey = CacheComponent::getKey();
        $this->flushCacheInput();
        if ($cacheData = CacheComponent::get($cacheKey)) {
            return $cacheData;
        } else {
            $query = $this->query;
            $data = $query->find($identifier);
            CacheComponent::set($cacheKey, $data, $cacheTimeout);
            $this->flushQuery();
            return $data;
        }
    }

    private function flushCacheInput() {
        $this->cacheKey = "";
        $this->cacheTimeout = 0;
    }

}
