<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

interface SqlIndexType
{
    public function getUpMethodName(): string;
    public function getDownMethodName(): string;
}
