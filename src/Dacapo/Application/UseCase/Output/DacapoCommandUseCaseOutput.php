<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

final class DacapoCommandUseCaseOutput
{
    /**
     * @param array<int, string> $generatedFileNameList
     */
    public function __construct(public array $generatedFileNameList)
    {
    }
}
