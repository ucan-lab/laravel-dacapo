<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

final class DacapoCommandUseCaseOutput
{
    /**
     * @param array<int, array<string, string>> $migrationBodies
     */
    public function __construct(public array $migrationBodies)
    {
    }
}
