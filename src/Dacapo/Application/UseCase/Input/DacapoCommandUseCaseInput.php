<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input;

final class DacapoCommandUseCaseInput
{
    /**
     * @var array<string, mixed>
     */
    public array $schemaBodies;

    /**
     * @param array<string, mixed> $schemaBodies
     */
    public function __construct(array $schemaBodies)
    {
        $this->schemaBodies = $schemaBodies;
    }
}
