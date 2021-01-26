<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

class IndexModifierName
{
    /**
     * @var string|array
     */
    protected $name;

    /**
     * IndexName constructor.
     * @param string|array $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string|array
     */
    public function getName()
    {
        return $this->name;
    }
}
