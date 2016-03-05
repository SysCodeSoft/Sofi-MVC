<?php

namespace Sofi\mvc;

class Layout extends \stdClass
{

    use \Sofi\mvc\traits\view\Out;

    const VIEW_EXT = '.phtml';

    protected $path = '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;
    protected $name = 'main';
    protected $content = [];
    protected $helpers = [];

    public function __construct($path = null)
    {
        if ($path !== null) {
            $this->path = $path;
        }
    }
        
    public function __get($name)
    {
        return !empty($this->content[$name]) ? $this->content[$name] : '';
    }

    function addContent($content)
    {
        if (is_array($content)) {
            $this->content = array_merge($this->content, $content);
        } else {
            $this->content[] = $content;
        }

        return $this;
    }

    function setContent(array $content)
    {
        $this->content[] = $content;

        return $this;
    }

    public function contents()
    {
        return implode(' ', $this->content);
    }

    public function render()
    {
        ob_start();
        $this->out();

        return ob_get_clean();
    }

}
