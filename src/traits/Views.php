<?php

namespace Sofi\mvc\traits;

trait Views
{

    protected $views = [];

    /**
     * 
     * @param string $name
     * @param boolean $global Choise base path to view files
     * @return \Sofi\mvc\View
     */
    protected function view($name, $global = false)
    {
        if (!isset($this->views[$name])) {
            $this->views[$name] = new \Sofi\mvc\View(
                    $global ? './../app/resources/views' : dirname(__FILE__) . DS . '../resources/views/'
            );
            $this->views[$name]->name($name);
        }

        return $this->views[$name];
    }

    /**
     * 
     * @param string $name View name
     * @param array $params Params for view
     * @param string $layout Layout name
     * @return string
     */
    protected function render($name, $params = [], $layout = null)
    {
        $view = $this->view($name);
        if ($layout != null) $view->layout($layout);
        $view->params($params);
        return $view->render();
    }

}
