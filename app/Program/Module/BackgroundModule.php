<?php


namespace App\Program\Module;


use App\Utils\RandomGenerator;
use DOMDocument;
use DOMElement;

class BackgroundModule implements Module
{

    public function getHtmlCode(): DOMElement
    {
        $dom = new DOMDocument();
        $div = $dom->createElement('div');
        $div->setAttribute('class', 'module_1');
        return $div;
    }

    public function getJsCode(): string
    {
        return '';
    }

    public function getCssCode(): string
    {
        return PHP_EOL . '.module_1 {'
            . PHP_EOL . "\t" . 'background: ' . RandomGenerator::generateColor() .';'
            . PHP_EOL . "\t" . 'width: 100%;'
            . PHP_EOL . "\t" . 'height: 200px;'
            . PHP_EOL . "\t" . 'display: block;'
            . PHP_EOL . ' }' . PHP_EOL;
    }
}
