<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input;

class DacapoCommandUseCaseInput
{
    public array $schemaFiles;

    /**
     * @param array $schemaFiles
     */
    public function __construct(array $schemaFiles)
    {
        $this->schemaFiles = $schemaFiles;
    }
}
