<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

class ColumnName
{
    protected string $name;
    protected $args;

    /**
     * ColumnName constructor.
     * @param string $name
     * @param mixed $args
     */
    public function __construct(string $name, $args)
    {
        $this->name = $name;
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }
}
