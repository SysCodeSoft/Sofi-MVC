<?php

namespace Sofi\MVC\traits\view;

trait Out
{

    protected function out()
    {
        $file = realpath($this->path) . DIRECTORY_SEPARATOR . $this->name . static::VIEW_EXT;
        if (file_exists($file)) {
            if (!empty($this->params))
                extract($this->params);
            include $file;
        } else {
            throw new \Exception('View not found ' . $file);
        }
    }

    protected function snippet($name, $params = [])
    {
        $file = realpath($this->path . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'snippets') . DIRECTORY_SEPARATOR . $name . static::VIEW_EXT;
        if (file_exists($file)) {
            extract($params);
            include $file;
        } else {
            throw new \Exception('Snippet not found ' . $name);
        }
    }

}
