<?php

namespace Sofi\mvc;

class BaseController
{
    protected $initialized = false;
    
    protected $Context = null;
    
    function init($Context = null)
    {
        if (!$this->initialized) {
            
            $this->Context = $Context;
            
            $this->initialized = true;
        }
    }

    function end()
    {
        $this->initialized = false;
    }

}
