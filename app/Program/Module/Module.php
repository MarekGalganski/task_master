<?php


namespace App\Program\Module;


use DOMElement;

interface Module
{
    public function getHtmlCode(): DOMElement;
    public function getJsCode(): string;
    public function getCssCode(): string;
}
