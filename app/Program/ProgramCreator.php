<?php


namespace App\Program;


use App\Exceptions\CommandParamException;
use App\Program\Module\BackgroundModule;
use App\Program\Module\ButtonModule;
use App\Utils\RandomGenerator;
use DOMDocument;

class ProgramCreator
{
    private string $programPath;
    private string $programName;
    private string $rootPath;
    private ParamsValidator $paramsValidator;
    private DOMDocument $htmlDOM;

    private BackgroundModule $backgroundModule;
    private ButtonModule $buttonModule;

    public function __construct(ParamsValidator $paramsValidator)
    {
        $this->paramsValidator = $paramsValidator;
        $this->htmlDOM = new DOMDocument();
        $this->rootPath = realpath('./..');

        $this->backgroundModule = new BackgroundModule();
        $this->buttonModule = new ButtonModule();
    }

    /**
     * @param array $data
     * @throws CommandParamException
     */
    public function create(array $data): void
    {
        $this->assignParams($data);
        $this->prepareHtmlTemplate();
        $this->createNewProgramDirectory();
        $this->createHtmlFile();
        $this->createCssFile();
        $this->createJsFile();
    }

    /**
     * @param $data
     * @throws CommandParamException
     */
    private function assignParams($data): void
    {
        $this->paramsValidator->validate($data);
        $this->programName = $data['program_name'];
    }

    private function createNewProgramDirectory(): void
    {
        $this->programPath = $this->rootPath . '/' . $this->programName;
        mkdir($this->programPath);
    }

    private function createHtmlFile(): void
    {
        $backgroundModule = $this->htmlDOM->importNode($this->backgroundModule->getHtmlCode());
        $buttonModule = $this->htmlDOM->importNode($this->buttonModule->getHtmlCode(), true);
        $backgroundModule->appendChild($buttonModule);

        $body = $this->htmlDOM->getElementsByTagName('body');
        $body = $body->item(0);
        $body->insertBefore($backgroundModule, $body->firstChild);
        $htmlString = $this->htmlDOM->saveHTML();

        file_put_contents($this->programPath . '/index.html', $htmlString);
    }

    private function prepareHtmlTemplate(): void
    {
        $html = $this->htmlDOM->createElement('html');
        $html->setAttribute('lang', 'en');
        $head = $this->htmlDOM->createElement('head');

        $title = $this->htmlDOM->createElement('title', $this->programName);

        $link = $this->htmlDOM->createElement('link');
        $link->setAttribute('rel', 'stylesheet');
        $link->setAttribute('href', './app.css');

        $head->appendChild($title);
        $head->appendChild($link);

        $script = $this->htmlDOM->createElement('script');
        $script->setAttribute('src', './app.js');

        $body = $this->htmlDOM->createElement('body');
        $body->appendChild($script);

        $html->appendChild($head);
        $html->appendChild($body);
        $this->htmlDOM->appendChild($html);
    }

    private function createCssFile(): void
    {
        $cssString = $this->backgroundModule->getCssCode();
        $cssString .= $this->buttonModule->getCssCode();

        file_put_contents($this->programPath . '/app.css', $cssString);
    }

    private function createJsFile(): void
    {
        $jsFile = $this->backgroundModule->getJsCode();
        $jsFile .= $this->buttonModule->getJsCode();
        file_put_contents($this->programPath . '/app.js', $jsFile);
    }
}
