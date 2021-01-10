<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SqlIndexType;

class IndexType implements SqlIndexType
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