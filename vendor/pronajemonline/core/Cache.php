<?php

namespace pronajem;

/**
 * Provides basic caching functionality within the application.
 *
 * Utilizing the Singleton pattern through the TSingletone trait, this class
 * offers methods to set, get, and delete cached data. Cached data is stored in files,
 * with each cache entry identifiable by a unique key. The cache mechanism supports
 * setting a time-to-live for each cache entry, after which the data is considered expired.
 */
class Cache {

    use TSingletone;

    /**
     * Stores data in the cache under a specific key for a certain duration.
     *
     * @param string $key The unique key under which the data is stored.
     * @param mixed $data The data to be cached.
     * @param int $seconds The time-to-live of the cache entry in seconds. Defaults to 3600 seconds (1 hour).
     * @return bool Returns true if the data was successfully cached, false otherwise.
     */
    public function set($key, $data, $seconds = 3600){
        if($seconds) {
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieves cached data by its key if it's not expired.
     *
     * @param string $key The key of the cached data to retrieve.
     * @return mixed|false The cached data if found and not expired, false otherwise.
     */
    public function get($key){
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)){
            $content = unserialize(file_get_contents($file));
            if(time() <= $content['end_time']){
                return $content;
            }
            unlink($file);
        }
        return false;
    }

    /**
     * Deletes a cache entry by its key.
     *
     * @param string $key The key of the cache entry to delete.
     */
    public function delete($key) {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)){
            unlink($file);
        }
    }

}