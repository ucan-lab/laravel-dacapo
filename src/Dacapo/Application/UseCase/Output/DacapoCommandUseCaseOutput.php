<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

final class DacapoCommandUseCaseOutput
{
    public array $migrationBodies;

    /**
     * @param array $migrationBodies
     */
    public function __construct(array $migrationBodies)
    {
        $this->migrationBodies = $migrationBodies;
    }
}
