<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

final class FullTextType implements IndexModifierType
{
    public function __construct()
    {
    }

    public function getUpMethodName(): string
    {
        return 'fullText';
    }

    public function getDownMethodName(): string
    {
        return 'dropFullText';
    }
}
