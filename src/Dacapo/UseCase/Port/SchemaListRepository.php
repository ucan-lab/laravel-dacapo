<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Port;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFile;

interface SchemaListRepository
{
    public function get(): SchemaList;

    public function init(): bool;

    public function clear(): bool;

    public function saveFile(SchemaFile $file): bool;
}
