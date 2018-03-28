<?php

namespace Sofi\mvc;

abstract class Action extends \stdClass
{

    use \Sofi\Base\traits\Init;

    /**
     * @var \Sofi\Context $Context
     */
    protected $Context = null;

    public function __construct()
    {
        ;
    }
    
    abstract public function run(...$params);

}
