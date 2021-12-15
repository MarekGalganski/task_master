<?php


namespace App\Program;


use App\Exceptions\CommandParamException;
use App\Utils\RandomGenerator;

class ProgramCreator
{
    private string $programPath;
    private string $programName;
    private string $rootPath;
    private ParamsValidator $paramsValidator;
    public function __construct(ParamsValidator $paramsValidator)
    {
        $this->paramsValidator = $paramsValidator;
        $this->rootPath = realpath('./..');
    }

    /**
     * @param array $data
     * @throws CommandParamException
     */
    public function create(array $data): void
    {
        $this->assignParams($data);
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
        $htmlString = '<!DOCTYPE html>' . PHP_EOL . '<html lang="en">' . PHP_EOL . '<head>' . PHP_EOL . "\t"
            . '<link rel="stylesheet" href="./app.css" />' . PHP_EOL . "\t" . '<title>'
            . $this->programName . '</title>' . PHP_EOL
            . '</head>' . PHP_EOL . '<body>' . PHP_EOL;

        $htmlString .= '<div class="module_1"></div>' . PHP_EOL;

        $htmlString .= '<script src="./app.js"></script>' . PHP_EOL . '</body>' . PHP_EOL . '</html>' . PHP_EOL;
        file_put_contents($this->programPath . '/index.html', $htmlString);
    }

    private function createCssFile(): void
    {
        $cssString = '.module_1 {' . PHP_EOL . "\t" . 'background: '
            . RandomGenerator::generateColor() .';' . PHP_EOL . "\t"
            . 'width: 100%;' . PHP_EOL . "\t" . 'height: 200px;' . PHP_EOL . "\t"
            . 'display: block;' . PHP_EOL . ' }' . PHP_EOL . PHP_EOL;

        file_put_contents($this->programPath . '/app.css', $cssString);
    }

    private function createJsFile(): void
    {
        $jsFile = 'function onReady() {' . PHP_EOL;
        $jsFile .= "\t" . 'console.log(\'onReady module_1\')' . PHP_EOL;

        $jsFile .= '}' . PHP_EOL . PHP_EOL . 'function onViewable() {' . PHP_EOL;
        $jsFile .= "\t" . 'console.log(\'onViewable module_1\')' . PHP_EOL;

        $jsFile .= '}' . PHP_EOL . PHP_EOL . 'onReady()' . PHP_EOL . 'setTimeout(function() {'
            . PHP_EOL . "\t" . 'onViewable()' . PHP_EOL . '}, 500)' . PHP_EOL;

        file_put_contents($this->programPath . '/app.js', $jsFile);
    }
}
