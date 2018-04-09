<?php

namespace Sofi\mvc;

class BaseController extends \stdClass
{

    use \Sofi\Base\traits\Init;

    /**
     * @var \Sofi\Context $Context
     */
    protected $Context = null;
    
    public function run($action, $params)
    {
        return call_user_func_array([$this, $action], $params);
    }

}
