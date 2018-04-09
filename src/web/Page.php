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

    public function createKeywords(array $list, string $prefix = '', string $postfix = '')
    {
        if ($prefix != '') {
            if (!in_array($prefix, $this->keywords)) {
                $this->keywords[] = $prefix;
            }
            $prefix = $prefix . ' ';
        }
        if ($postfix != '')
            $postfix = ' ' . $postfix;
        foreach ($list as $value) {
            $word = $prefix . $value . $postfix;
            if (!in_array($word, $this->keywords)) {
                $this->keywords[] = $word;
            }
        }
    }

}
