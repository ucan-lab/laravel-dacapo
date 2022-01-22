<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

interface ColumnModifier
{
    public function createMigrationMethod(): string;
}
