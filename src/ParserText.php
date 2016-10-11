<?php

namespace ParserText;

class ParserText
{
    private $template = '';

    /**
     * construct
     * @param string $template
     */
    public function __construct($template)
    {
        $this->setTemplate($template);
    }

    /**
     * setTemplate
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * getTemplate
     * @return string $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * run
     * @param  string $text
     * @return false|array
     */
    public function run($text)
    {
        $template = $this->getTemplate();

        $preparedText = $this->trimText($text);
        $preparedTemplate = $this->prepareTemplate($template);

        return $this->extractData($preparedText, $preparedTemplate);
    }

    /**
     * Trim text - remove multiple whitespaces and replace it with single space
     * @param  string $text
     * @return string
     */
    private function trimText($text)
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }

    /**
     * Prepare template - replace {%Var%} to (?<Var>.*)
     * @param  string $template
     * @return string
     */
    private function prepareTemplate($template)
    {
        $trimTemplate = $this->trimText($template);
        $quoteTemplate = preg_quote($trimTemplate, '/');

        $patterns = [
            '/\\\{% (.*) %\\\}/U', // replace {%Var%}
        ];
        $replacements = [
            '(?<$1>.*)',          // to (?<Var>.*)
        ];

        return preg_replace($patterns, $replacements, $quoteTemplate);
    }

    /**
     * extractData
     * @param  string $text
     * @param  string $template
     * @return false|array
     */
    private function extractData($text, $template)
    {
        preg_match('/' . $template . '/s', $text, $matches);

        $keys = array_filter(array_keys($matches), 'is_string');
        $filterMatches = array_intersect_key($matches, array_flip($keys));

        if (empty($filterMatches)) {
            return false;
        }

        $cleanMatches = array_map(function($item) {
            return trim(strip_tags($item));
        }, $filterMatches);

        return $cleanMatches;
    }
}
