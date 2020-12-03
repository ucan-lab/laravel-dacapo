<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

interface SchemasStorage
{
    public function deleteDirectory(): bool;
}
