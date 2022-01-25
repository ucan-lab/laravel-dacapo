<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input;

final class DacapoCommandUseCaseInput
{
    public array $schemaBodies;

    /**
     * @param array $schemaBodies
     */
    public function __construct(array $schemaBodies)
    {
        $this->schemaBodies = $schemaBodies;
    }
}
