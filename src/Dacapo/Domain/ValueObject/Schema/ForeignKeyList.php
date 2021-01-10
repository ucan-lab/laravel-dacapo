<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

class ForeignKeyList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param ForeignKey $foreign
     * @return ForeignKeyList
     */
    public function add(ForeignKey $foreign): self
    {
        $this->attributes[] = $foreign;

        return $this;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        if (empty($this->attributes)) {
            return false;
        }

        return true;
    }

    /**
     * @return ForeignKey[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
