<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

final class IndexType implements IndexModifierType
{
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getUpMethodName(): string
    {
        return 'index';
    }

    /**
     * @return string
     */
    public function getDownMethodName(): string
    {
        return 'dropIndex';
    }
}
