<?php

namespace Sofi\MVC\traits\view;

trait Helpers
{

    protected $helpers = [];
    
        
    public function registerHelper($name, $item)
    {
        $this->helpers[$name] = $item;

        return $this;
    }
        
    function __call($name, $arguments)
    {
        if (empty($this->helpers[$name])) {
            $class = '\\Sofi\\helpers\\'.$name;
            $this->helpers[$name] = new $class($arguments);
        }
        
        return $this->helpers[$name];
    }
    
}
