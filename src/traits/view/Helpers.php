<?php

namespace Sofi\mvc\traits\view;

trait Helpers
{

    protected $helpers = [];
        
    function __call($name, $arguments)
    {
        if (empty($this->helpers[$name])) {
            $class = '\\Sofi\\helpers\\'.$name;
            $this->helpers[$name] = new $class($arguments);
        }
        
        return $this->helpers[$name];
    }
    
}
