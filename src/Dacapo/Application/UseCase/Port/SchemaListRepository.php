<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Port;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;

interface SchemaListRepository
{
    public function get(): SchemaList;
}
