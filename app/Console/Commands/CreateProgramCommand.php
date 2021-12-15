<?php

namespace App\Console\Commands;

use App\Exceptions\CommandParamException;
use App\Program\ProgramCreator;
use Illuminate\Console\Command;

class CreateProgramCommand extends Command
{

    private ProgramCreator $programCreator;

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
    public function __construct(ProgramCreator $programCreator)
    {
        parent::__construct();
        $this->programCreator = $programCreator;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->programCreator->create($this->assignParams());
        } catch (CommandParamException $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    private function assignParams(): array
    {
        $params['program_name'] = $this->ask('Enter the name of the program:');
        return $params;
    }

}
