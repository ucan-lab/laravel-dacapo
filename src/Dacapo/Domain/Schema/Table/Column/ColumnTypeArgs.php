<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column;

use function is_array;
use function is_string;

final class ColumnTypeArgs
{
    private function __construct(
        private mixed $args,
        private bool $isArray,
        private bool $isString = false,
        private bool $isNumeric = false,
    ) {
    }

    /**
     * @return static
     */
    public static function factory(
        mixed $args,
        bool $isArray = false,
        bool $isString = false,
        bool $isNumeric = false,
    ): self {
        if ($isNumeric && is_string($args)) {
            $args = array_map(fn ($args) => trim($args), explode(',', $args));
        }

        return new self($args, $isArray, $isString, $isNumeric);
    }

    public function hasArgs(): bool
    {
        return $this->args !== null;
    }

    public function typeArgs(): string
    {
        if (is_array($this->args) && $this->isArray) {
            return "['" . implode("', '", $this->args) . "']";
        } elseif (is_array($this->args) && $this->isString) {
            return "'" . implode("', '", $this->args) . "'";
        } elseif (is_array($this->args) && $this->isNumeric) {
            return implode(', ', $this->args);
        } elseif (is_array($this->args)) {
            return implode(', ', $this->args);
        } elseif (is_numeric($this->args)) {
            return (string) $this->args;
        }

        return "'" . $this->args . "'";
    }
}
