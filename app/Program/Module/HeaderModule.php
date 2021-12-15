<?php


namespace App\Program\Module;


use DOMDocument;
use DOMElement;

class HeaderModule implements Module
{

    public function getHtmlCode(): DOMElement
    {
        $dom = new DOMDocument();
        $div = $dom->createElement('div');
        $div->setAttribute('class', 'header');
        $h1 = $dom->createElement('h1', 'Hello World!');
        $div->appendChild($h1);
        return $div;
    }

    public function getJsCode(): string
    {
        return '';
    }

    public function getCssCode(): string
    {
        return PHP_EOL . '.header {'
            . PHP_EOL . "\t" . 'display: flex;'
            . PHP_EOL . "\t" . 'justify-content: center;'
            . PHP_EOL . "\t" . 'align-items: center;'
            . PHP_EOL . "\t" . 'height: 100px;'
            . PHP_EOL . '}' . PHP_EOL;
    }
}
