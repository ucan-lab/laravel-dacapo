<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

final class DacapoMakeModelsCommandUseCaseOutput
{
    /**
     * @param array<int, string> $tableNameList
     */
    public function __construct(public array $tableNameList)
    {
    }
}
