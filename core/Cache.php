<?php

namespace PHPFramework;

class Cache
{
    public function set($key, $data, $seconds = CACHE_TIME): void
    {
        dump('set key on cache: '.$key);
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        $cache_file = $this->getCacheFilePathAndName($key);
        file_put_contents($cache_file, serialize($content));
        app()->set($key,$data);

    }

    public function get($key, $default = null)
    {
        $cache_file = $this->getCacheFilePathAndName($key);
        if (file_exists($cache_file)) {
            $content = unserialize(file_get_contents($cache_file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($cache_file);
        }
        return $default;
    }

    public function getOrIfNotExistSetAndGet($key,$second=CACHE_TIME)
    {
        $value=$this->get($key);
        if(!$value){
            dump('key not found and set on cache:'.$key);
            $value=db()->findAll($key);
            $this->set($key,$value,$second);
            app()->set($key,$value);
        }
        return $value;
    }
    
    public function forget($key): void
    {
        $cache_file = $this->getCacheFilePathAndName($key);
        if(file_exists($cache_file)){
            unlink($cache_file);
        }
    }

    /**
     * @param $key
     * @return string
     */
    private function getCacheFilePathAndName($key): string
    {
        return CACHE . '/' . md5($key) . '.txt';
    }
}