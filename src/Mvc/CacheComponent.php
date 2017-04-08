<?php

namespace Mvc;

use Predis\Client as PredisClient;

class CacheComponent {

    const cachePattern = 'U(:user_id)_(:controller):(:method)_S:(:salt)_P:(:params)';

    /**
     * Section Cache Key oluşturur
     * @param array $map
     * @return type
     */
    private static $scheme, $host, $port;
    private static $conn;
    private static $cacheKeyParams = [];

    public static function setConf($conf) {
        if (!empty($conf)) {
            self::$scheme = $conf["scheme"];
            self::$host = $conf["host"];
            self::$port = $conf["port"];
        }
    }

    public static function Connect() {
        try {
            $client = new PredisClient([
                'scheme' => self::$scheme,
                'host' => self::$host,
                'port' => self::$port,
            ]);
            self::$conn = $client;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function Disconnect() {
        self::$conn->disconnect();
    }

    public static function set($key, $data, $timeout = 0) {
        self::Connect();
        try {
            if (is_array($data) || is_object($data)) {
                $data = serialize($data);
            }
            if ($timeout > 0) {
                self::$conn->set($key, $data);
                self::$conn->expire($key, $timeout);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
        self::flushCacheKey();
        self::Disconnect();
    }

    public static function get($key) {
        self::Connect();
        try {
            $data = self::$conn->get($key);
            $r_data = @unserialize($data);
            if ($r_data != false) {
                return $r_data;
            } else {
                return $data;
            }
            return $data;
        } catch (Exception $e) {
            
        }
        self::Disconnect();
        self::flushCacheKey();
        return [];
    }

    public static function addKey($k, $v) {
        self::$cacheKeyParams[$k] = $v;
    }

    public static function getKey() {
        $cacheKeyArr = [];
        foreach (self::$cacheKeyParams as $key => $val) {
            $cacheKeyArr[] = $key . ":" . $val;
        }

        return implode("_", $cacheKeyArr);
    }

    private static function flushCacheKey() {
        self::$cacheKeyParams = [];
    }

}
