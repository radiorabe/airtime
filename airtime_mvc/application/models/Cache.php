<?php

class Cache
{

    private static function getNamespace()
    {
        $CC_CONFIG = Config::getConfig();

        $instanceId = $CC_CONFIG['rabbitmq']['user'];
        if (!is_numeric($instanceId)) {
            throw new Exception("Invalid instance id in " . __FUNCTION__ . ": " . $instanceId);
        }

        // We use this extra "namespace key" to implement faux cache clearing.
        $namespaceKeyKey = "namespace_{$instanceId}";
        return $namespaceKeyKey;
    }

    private static function generateNamespaceKeyValue()
    {
        return rand();
    }

    private function createCacheKey($key, $isUserValue, $userId = null) {
        
        $CC_CONFIG = Config::getConfig();
        $apiKey = $CC_CONFIG["apiKey"][0];

        $memcached = self::getMemcached();

        $namespaceKeyKey = self::getNamespace();
        $namespaceKeyVal = $memcached->get($namespaceKeyKey);
        //Create the namespace key value if it doesn't exist
        if($namespaceKeyVal===false) {
            $namespaceKeyVal = self::generateNamespaceKeyValue();
            $memcached->set($namespaceKeyKey, $namespaceKeyVal);
        }

        if ($isUserValue) {
            $cacheKey = "{$namespaceKeyVal}{$key}{$userId}{$apiKey}";
        }
        else {
            $cacheKey = "{$namespaceKeyVal}{$key}{$apiKey}";
        }

        return $cacheKey;
    }

    private static function getMemcached() {
        $CC_CONFIG = Config::getConfig();

        static $memcached = null;
        if (is_null($memcached)) {
            $memcached = new Memcached();
            /*
            //$server is in the format "host:port"
            if (!is_null($CC_CONFIG['memcached']['servers'])) {
                foreach ($CC_CONFIG['memcached']['servers'] as $server) {
                    list($host, $port) = explode(":", $server);
                    $memcached->addServer($host, $port);
                }
            }*/
            //$memcached->addServer('', '');
        }
        return $memcached;
    }

    public function store($key, $value, $isUserValue, $userId = null) {

        $cacheKey = self::createCacheKey($key, $isUserValue, $userId);
        $cache = self::getMemcached();
        return $cache->set($cacheKey, $value);
    }
    
    public function fetch($key, $isUserValue, $userId = null) {
            
        $cacheKey = self::createCacheKey($key, $isUserValue, $userId);
        $cache = self::getMemcached();
        $found = false;
        $value = $cache->get($cacheKey);
        $result = $cache->getResultCode();
        if ($cache->getResultCode() === Memcached::RES_SUCCESS) {
            $found = true;
        }
        //need to return something to distinguish a cache miss from a stored "false" preference.
        return array(
            "found" => $found,
            "value" => $value,
        );
    }

	public static function clear()
	{
        //See "Deleting by Namespace":
        //https://code.google.com/p/memcached/wiki/NewProgrammingTricks
        $memcached = self::getMemcached();
        $namespaceKeyKey = self::getNamespace();
        $namespaceKeyVal = self::generateNamespaceKeyValue();
        $memcached->set($namespaceKeyKey, $namespaceKeyVal);
    }
}
