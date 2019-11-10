<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Method
{
    private $name;
    private $args;

    /**
     * @param string $name
     * @param array $args
     */
    public function __construct(string $name, array $args)
    {
        $this->name = $name;
        $this->args = self::wrapArgs($args);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('->%s(%s)', $this->name, implode(', ', $this->args));
    }

    /**
     * @param string $name
     * @param mixed ...$args
     * @return self
     */
    public static function call(string $name, ...$args): self
    {
        return new self($name, $args);
    }

    /**
     * @param array $args
     * @return array
     */
    private static function wrapArgs(array $args): array
    {
        foreach ($args as $index => $arg) {
            $args[$index] = $arg instanceof Literal ? $arg : Literal::of($arg);
        }

        return $args;
    }
}
