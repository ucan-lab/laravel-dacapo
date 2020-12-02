<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

interface MigrationsStorage
{
    public function getFiles(): array;

    public function delete(string $name): bool;
}
