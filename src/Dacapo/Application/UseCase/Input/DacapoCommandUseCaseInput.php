<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input;

final class DacapoCommandUseCaseInput
{
    /**
     * @param array<string, mixed> $schemaBodies
     */
    public function __construct(public array $schemaBodies)
    {
    }
}
