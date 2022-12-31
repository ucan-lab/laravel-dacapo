<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub;

interface MigrationCreateStub
{
    public function getStub(): string;

    /**
     * @return array<int, string>
     */
    public function getNamespaces(): array;
}
