<?php

namespace Sofi\mvc;

use Sofi\Base\interfaces\InitializedInterface;

class Layout extends \stdClass implements InitializedInterface {

    use \Sofi\mvc\traits\view\Out;
    use \Sofi\Base\traits\Init;

    const VIEW_EXT = '.phtml';

    protected $path = '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR;
    protected $name = 'main';
    protected $content = [];
    protected $helpers = [];
    protected $params = [];

    public function __construct(string $path = null) {
        if ($path !== null) {
            $this->path = $path;
        }
    }
    
    public static function createForApp($app = BASE_PATH.'app') {
        return (new static($app . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'layouts'));
    }

    public function __get($name) {
        return !empty($this->content[$name]) ? $this->content[$name] : '';
    }

    public function addHelper($name, $item) {
        $this->helpers[$name] = $item;

        return $this;
    }
    
    public function join($name, $value)
    {
        $this->params[$name] = $value;
        
        return $this;
    }
    
    function __call($name, $args) {
        if (!empty($this->helpers[$name])) {
            return $this->helpers[$name];
        } else {
            return null;
        }
    }

    public function name($name) {
        $this->name = $name;

        return $this;
    }
    
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    protected function prepare($contents) {
        $result = [];

        if (is_array($contents)) {
            foreach ($contents as $cont) {
                if (is_object($cont) && $cont instanceof View) {
                    $ln = $cont->getLayout();
                    if ($ln != '') {
                        $this->name = $ln;
                    }
                    $result[] = $cont->render();
                } else {
                    $result[] = $cont;
                }
            }
        } elseif (is_object($contents) && $contents instanceof View) {
            $ln = $contents->getLayout();
            if ($ln != '') {
                $this->name = $ln;
            }
            $result[] = $contents->render();
        } else {
            $result[] = $contents;
        }

        return $result;
    }

    function addContent($contents) {
        $content = $this->prepare($contents);
        
        $this->content = array_merge($this->content, $content);

        return $this;
    }

    function setContent(array $content) {
//     var_dump($content);die();
        $this->content = $this->prepare($content);

        return $this;
    }

    public function contents() {
        return implode('', $this->content);
    }
    
    public function render() {
        ob_start();
        $this->out();

        return ob_get_clean();
    }

}
