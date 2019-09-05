<?php

namespace UcanLab\LaravelDacapo\Storage;

interface Storage
{
    public function getFiles(): Files;

    public function exists(?string $path): bool;

    public function makeDirectory(): bool;

    public function deleteDirectory(): bool;

    public function getPath(?string $path = null): string;
}
