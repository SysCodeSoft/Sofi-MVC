<?php

namespace Sofi\mvc\web;

class View extends \stdClass
{

    use \Sofi\mvc\traits\view\Out;

    const VIEW_EXT = '.phtml';

    protected $path = '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
    protected $name = 'index';
    protected $params = [];
    protected $result = null;
    
    protected $blocks = [];
    
    public $Context;

    public function __construct($path = null)
    {
        if ($path !== null) {
            $this->path = $path;
        }
    }
    
    public static function createForApp($app = 'app')
    {
        return (new static('..' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views'));
    }
    

    public function name($name)
    {
        $this->name = $name;
        $this->result = null;
        return $this;
    }
    
    public function params(array $params)
    {
        $this->params = $params;
        $this->result = null;
        return $this;
    }

    public function clear()
    {
        $this->result = null;
        $this->blocks = [];
        return $this;
    }
    
    function start() {
        ob_start();
    }
    
    function end($name) {
        $this->blocks[$name] = ob_get_clean();
    }
    
    function block($name) {
        return !empty($this->blocks[$name]) ? $this->blocks[$name] : '';
    }

    function render($update = false)
    {
        if ($update) {
            $this->result = null;
        }

        if ($this->result === null) {
            ob_start();
            $this->out();
            $this->result = ob_get_clean();
        }
        return $this->result;
    }
    
    function __toString()
    {
        return $this->render();
    }
}
