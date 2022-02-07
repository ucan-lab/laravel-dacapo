<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

final class DacapoCommandUseCaseOutput
{
    /**
     * @var array<int, array<string, string>>
     */
    public array $migrationBodies;

    /**
     * @param array<int, array<string, string>> $migrationBodies
     */
    public function __construct(array $migrationBodies)
    {
        $this->migrationBodies = $migrationBodies;
    }
}
