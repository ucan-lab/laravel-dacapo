<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Literal
{
    private $value;
    private $raw;

    public function __construct($value, bool $raw = false)
    {
        $this->value = $value;
        $this->raw = $raw;
    }

    public function __toString()
    {
        if ($this->raw) {
            return sprintf('DB::raw(%s)', var_export($this->value, true));
        }

        return var_export($this->value, true);
    }

    public static function of($value)
    {
        return new self($value);
    }

    public static function raw($value)
    {
        return new self($value, true);
    }
}
