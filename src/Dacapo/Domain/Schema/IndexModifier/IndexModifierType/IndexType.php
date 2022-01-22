<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;

class IndexType implements IndexModifierType
{
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