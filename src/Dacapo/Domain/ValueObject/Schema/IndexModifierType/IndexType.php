<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType;

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
