<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub;

interface MigrationUpdateStub
{
    /**
     * @return string
     */
    public function getStub(): string;

    /**
     * @return array<int, string>
     */
    public function getNamespaces(): array;
}
