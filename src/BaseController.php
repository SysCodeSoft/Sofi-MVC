<?php

namespace Sofi\mvc;

class BaseController
{

    protected $initialized = false;
    
    protected $Context = null;

    function init($Request, $Response, $Route)
    {
        if (!$this->initialized) {
            
            $this->initialized = true;
        }
    }

    function end()
    {
        
    }

}
