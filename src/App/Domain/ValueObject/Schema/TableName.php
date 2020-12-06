<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

class TableName
{
    protected string $name;

    /**
     * TableName constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }
}
