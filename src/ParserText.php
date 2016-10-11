<?php

namespace ParserText;

class ParserText
{
    private $template = '';

    public function __construct($template)
    {
        $this->setTemplate($template);
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function run($text)
    {
        return [];
    }
}
