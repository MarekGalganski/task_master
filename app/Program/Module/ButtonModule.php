<?php


namespace App\Program\Module;


use DOMDocument;
use DOMElement;

class ButtonModule implements Module
{

    public function getHtmlCode(): DOMElement
    {
        $dom = new DOMDocument();
        $div = $dom->createElement('div');
        $div->setAttribute('class', 'button');
        $button = $dom->createElement('button', 'Click Me!');
        $button->setAttribute('onclick', 'helloWorld()');
        $div->appendChild($button);
        return $div;
    }

    public function getJsCode(): string
    {
        return 'function helloWorld() {'
            . PHP_EOL . "\t" . 'alert("Hello World!");'
            . PHP_EOL . '}';
    }

    public function getCssCode(): string
    {
        return PHP_EOL . '.button {'
            . PHP_EOL . "\t" . 'display: flex;'
            . PHP_EOL . "\t" . 'justify-content: center;'
            . PHP_EOL . "\t" . 'align-items: center;'
            . PHP_EOL . "\t" . 'height: 100px;'
            . PHP_EOL . '}' . PHP_EOL;
    }
}
