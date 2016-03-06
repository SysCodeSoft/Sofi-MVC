<?php

namespace Sofi\mvc;

class View extends \stdClass
{

    use \Sofi\mvc\traits\view\Out;

    const VIEW_EXT = '.phtml';

    protected $path = '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views';
    protected $name = 'index';
    protected $params = [];
    protected $layout = '';
    protected $result = null;

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

    public function layout($name)
    {
        $this->layout = $name;
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
        return $this;
    }

    protected function _render($update = false)
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

    protected function _renderWidthLayout()
    {
        $content = $this->_render();

        $name = $this->name;
        $path = $this->path;
        $params = $this->params;

        $this->name = $this->layout;
        $this->path = realpath($this->path . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'layouts');
        $this->params = ['content' => $content];

        $rs = $this->_render(true);

        $this->name = $name;
        $this->path = $path;
        $this->params = $params;

        return $rs;
    }

    public function render($update = false)
    {
        if ($this->layout == '') {
            return $this->_render($update);
        } else {
            return $this->_renderWidthLayout();
        }
    }

}
