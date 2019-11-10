<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use Zend\Code\Generator\ValueGenerator;

class Literal
{
    private $value;
    private $raw;

    /**
     * @param mixed $value
     * @param bool $raw
     */
    public function __construct($value, bool $raw = false)
    {
        $this->value = $value;
        $this->raw = $raw;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $code = is_scalar($this->value) || is_null($this->value)
            ? var_export($this->value, true)
            : (new ValueGenerator($this->value, ValueGenerator::TYPE_ARRAY_SHORT, ValueGenerator::OUTPUT_SINGLE_LINE))->generate();

        return $this->raw ? sprintf('DB::raw(%s)', $code) : $code;
    }

    /**
     * @param mixed $value
     * @return self
     */
    public static function of($value): self
    {
        return new self($value);
    }

    /**
     * @param mixed $value
     * @return self
     */
    public static function raw($value): self
    {
        return new self($value, true);
    }
}
