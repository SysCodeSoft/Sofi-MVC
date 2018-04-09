<?php

namespace Sofi\mvc\web;

class View extends \Sofi\Base\Initialized
{
    use \Sofi\Base\traits\Init;

    const VIEW_EXT = '.phtml';

    protected $path = '..' . DS . 'app' . DS . 'resources' . DS . 'views';
    protected $name = 'index';
    protected $params = [];
    protected $blocks = [];
    protected $result = null;
    
    protected $realPath = '..' . DS . 'app' . DS . 'resources' . DS . 'views';
    protected $realName = 'index';
    
    /**
     *
     * @var \Sofi\Router\Context 
     */
    public $Context;
    public $Data;
    
    public $content = [];

    public function __construct($path = null)
    {
        if ($path !== null) {
            $this->path = $path;
        }
    }

    public static function createForApp($app = 'app')
    {
        return (new static('..' . DS . $app . DS . 'resources' . DS . 'views'));
    }

    public function name($name)
    {
        $this->name = $name;
        $this->result = null;
        return $this;
    }
    
    /**
     * 
     * @return \Sofi\mvc\web\Page
     */
    public function page()
    {
        return $this->Context->Page;
    }
    
    protected function setReal()
    {
        $toPath = explode(DS, $this->name);
        $toName = array_pop($toPath);
        
        $this->realName = $toName;   
        $this->realPath = realpath($this->path.DS.implode(DS,$toPath));
        
    }

    /**
     * 
     * @param type $data
     * @return $this
     */
    public function data($data)
    {
        $this->Data = $data;

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

    function begin()
    {
        ob_start();
    }

    function end($name)
    {
        $this->blocks[$name] = ob_get_clean();
    }

    function block($name)
    {
        return !empty($this->blocks[$name]) ? $this->blocks[$name] : '';
    }

    protected function out($file, $params = [], $error = true)
    {
        if (file_exists($file)) {
            extract($params);
            include $file;
            return true;
        } else {
            if (SOFI_MODE == \Sofi\Base\Sofi::SOFI_MODE_PROD)
                return false;
            else
            if ($error) {
                throw new \Sofi\Base\exceptions('View not found by path: ' . $file);                
            }
        }
    }

    protected function snippet($name, $params = [])
    {
        $file = realpath($this->path . DS . '..' . DS . 'snippets') . DS . $name . static::VIEW_EXT;
        $this->out($file, $params, false);
    }

    function render($update = false)
    {
        if ($update) {
            $this->result = null;
        }
        
        $this->setReal();

        if ($this->result === null) {
            ob_start();
            $file = $this->realPath . DS . $this->realName . static::VIEW_EXT;
            $this->out($file, $this->params);
            $this->result = ob_get_clean();
        }
        return $this->result;
    }

    function __toString()
    {
        return $this->render();
    }
    
    protected function prepare($contents)
    {
        $result = [];

        if (is_array($contents)) {
            foreach ($contents as $cont) {
                if (is_object($cont) && $cont instanceof View) {
                    $result[] = $cont->render();
                } else {
                    $result[] = $cont;
                }
            }
        } elseif (is_object($contents) && $contents instanceof View) {
            $result[] = $contents->render();
        } else {
            $result[] = $contents;
        }

        return $result;
    }

    function addContent($contents)
    {
        $content = $this->prepare($contents);

        $this->content = array_merge($this->content, $content);

        return $this;
    }
    
    public function __get($name)
    {
        return !empty($this->content[$name]) ? $this->content[$name] : '';
    }
    
    public function contents($name = null)
    {
        return $name == null ? implode('', $this->content) : $this->content[$name];
    }
    
    function __invoke($contents)
    {
        $this->addContent($contents);
        
        return $this->render();
    }

    public function join($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

}
