<?php

namespace Sofi\mvc;

class View extends \stdClass {
    const VIEW_EXT = '.phtml';

    protected $path = '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR;
    protected $name = 'index';
    protected $params = [];
    protected $layout = '';
    protected $result = null;
        
    public function __construct($path = null) {
        if ($path !== null) {
            $this->path = $path;
        }
    }
        
    public function name($name) {
        $this->name = $name;
        $this->result = null;
        return $this;
    }
    
    public function layout($name) {
        $this->layout = $name;
        $this->result = null;
        return $this;
    }

    public function params(array $params) {
        $this->params = $params;
        $this->result = null;
        return $this;
    }
    
    public function clear() {
        $this->result = null;
        return $this;
    }

    protected function view() {
        $file = realpath($this->path) . DIRECTORY_SEPARATOR . $this->name . static::VIEW_EXT;
        if (file_exists($file)) {
            extract($this->params);
            include $file;
        } else {
            throw new \Exception('View not found ' . $file);
        }
    }
    
    protected function snippet($name, $params = []) {
        $file = realpath($this->path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'snippets') . DIRECTORY_SEPARATOR . $name . static::VIEW_EXT;
        if (file_exists($file)) {
            extract($params);
            include $file;
        } else {
            throw new \Exception('Snippet not found ' . $name);
        }
    }

    protected function _render($update = false) {
        if ($update) {
            $this->result = null;
        }
        
        if ($this->result === null) {
            ob_start();
            $this->view();
            $this->result = ob_get_clean();
        }
        return $this->result;
    }
            
    protected function _renderWidthLayout() {
        $content = $this->_render();
        
        $name = $this->name;
        $path = $this->path;
        $params = $this->params;
        
        $this->name = $this->layout;
        $this->path = realpath($this->path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'layouts');
        $this->params = ['content' => $content];
        
        $rs = $this->_render(true);
        
        $this->name = $name;
        $this->path = $path;
        $this->params = $params;
        
        return $rs;
    }
    
    public function render($update = false) {
        if ($this->layout == '') {
            return $this->_render($update);
        } else {
            return $this->_renderWidthLayout();
        }
    }

}
