<?php

namespace App\Console\Commands;

use App\Exceptions\CommandParamException;
use Illuminate\Console\Command;

class CreateProgramCommand extends Command
{
    private string $programPath;
    private string $programName;
    private string $rootPath;
    private int $componentsNumber;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->rootPath = realpath('./..');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->assignParams();
            $this->createNewProgramDirectory();
            $this->createHtmlFile();
        } catch (CommandParamException $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    /**
     * @throws CommandParamException
     */
    private function assignParams(): void
    {
        $this->programName = $this->ask('Enter the name of the program:');
        $scannedRootDirectory = scandir($this->rootPath);
        if (in_array($this->programName, $scannedRootDirectory)) {
            throw new CommandParamException('Program name already exists.');
        }

        $this->componentsNumber = intval($this->ask('Enter the number of the components:'));
        if ($this->componentsNumber <= 0) {
            throw new CommandParamException('Enter valid number of components.');
        };
    }

    private function createNewProgramDirectory(): void
    {
        $this->programPath = $this->rootPath . '/' . $this->programName;
        mkdir($this->programPath);
    }

    private function createHtmlFile(): void
    {
        $htmlString = '<!DOCTYPE html>' . PHP_EOL . '<html lang="en">' . PHP_EOL . '<head>' . PHP_EOL . "\t"
            . '<link rel="stylesheet" href="./app.css" />' . PHP_EOL . "\t" . '<title>Test program</title>' . PHP_EOL
            . '</head>' . PHP_EOL . '<body>' . PHP_EOL;
        for ($i = 1; $i <= $this->componentsNumber; $i++) {
            $htmlString .= '<div class="module_' . $i . '"></div>' . PHP_EOL;
        }
        $htmlString .= '<script src="./app.js"></script>' . PHP_EOL . '</body>' . PHP_EOL . '</html>';
        file_put_contents($this->programPath . '/index.html', $htmlString);
    }
}
