<?php

namespace Sofi\MVC\traits;

trait Redirect
{

    protected function redirect($uri)
    {
        if (empty($this->Context)) {
            header('Location: ' . $uri);
        }
        return $this;
    }

    protected function gohome()
    {
        return $this->redirect('/');
    }

    protected function goback()
    {
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

}
