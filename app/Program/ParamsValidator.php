<?php


namespace App\Program;


use App\Exceptions\CommandParamException;

class ParamsValidator
{
    /**
     * @throws CommandParamException
     */
    public function validate(array $params): void
    {
        $this->validateProgramName($params['program_name']);
    }

    /**
     * @param string $programName
     * @throws CommandParamException
     */
    private function validateProgramName(string $programName): void
    {
        $scannedRootDirectory = scandir(realpath('./..'));
        if (in_array($programName, $scannedRootDirectory)) {
            throw new CommandParamException('Program name already exists.');
        }
    }
}
