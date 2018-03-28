<?php

namespace Sofi\mvc\web;

class Page extends \stdClass
{
    public $title = [];
    public $keywords = [];
    public $description = [];
    
    public function title($delimiter = '. ')
    {
        return implode($delimiter, $this->title);
    }
    
    public function keywords($delimiter = ', ')
    {
        return implode($delimiter, $this->keywords);
    }
    
    public function description($delimiter = '. ')
    {
        return implode($delimiter, $this->description);
    }
    
}
