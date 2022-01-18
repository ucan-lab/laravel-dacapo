<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Port;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;

interface SchemaListRepository
{
    public function get(): SchemaList;

    public function clear(): bool;
}
