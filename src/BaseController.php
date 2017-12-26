<?php

namespace Sofi\mvc;

class BaseController extends \stdClass
{
    use \Sofi\Base\traits\Init;
    
    protected $Context = null;

    public function __construct()
    {
        ;
    }
}
