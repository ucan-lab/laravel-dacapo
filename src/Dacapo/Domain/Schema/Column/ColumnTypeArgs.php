<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use function is_string;
use function is_array;

final class ColumnTypeArgs
{
    /**
     * @var mixed
     */
    private $args;

    /**
     * @var bool
     */
    private bool $isArray;

    /**
     * @var bool
     */
    private bool $isString;

    /**
     * @var bool
     */
    private bool $isNumeric;

    /**
     * @param mixed $args
     * @param bool $isArray
     * @param bool $isString
     * @param bool $isNumeric
     */
    private function __construct($args, bool $isArray, bool $isString = false, bool $isNumeric = false)
    {
        $this->args = $args;
        $this->isArray = $isArray;
        $this->isString = $isString;
        $this->isNumeric = $isNumeric;
    }

    /**
     * @param array<int, mixed>|string|int|null $args
     * @param bool $isArray
     * @param bool $isString
     * @param bool $isNumeric
     * @return static
     */
    public static function factory($args, bool $isArray = false, bool $isString = false, bool $isNumeric = false): self
    {
        if ($isNumeric && is_string($args)) {
            $args = array_map(fn ($args) => trim($args), explode(',', $args));
        }

        return new self($args, $isArray, $isString, $isNumeric);
    }

    /**
     * @return bool
     */
    public function hasArgs(): bool
    {
        return $this->args !== null;
    }

    /**
     * @return string
     */
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
