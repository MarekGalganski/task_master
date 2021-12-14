<?php

namespace App\Console\Commands;

use App\Exceptions\ProgramNameException;
use Illuminate\Console\Command;

class CreateProgramCommand extends Command
{
    private string $programPath;
    private string $programName;
    private string $rootPath;
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
            $this->programName = $this->ask('Enter the name of the program:');
            $this->validateProgramName();
        } catch (ProgramNameException $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    /**
     * @throws ProgramNameException
     */
    private function validateProgramName(): void
    {
        $scannedRootDirectory = scandir($this->rootPath);
        if (in_array($this->programName, $scannedRootDirectory)) {
            throw new ProgramNameException('Program name already exists');
        }
    }
}
