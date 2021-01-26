<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnModifier;

class DefaultModifier implements ColumnModifier
{
    protected $value;

    /**
     * DefaultModifier constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function createMigrationMethod(): string
    {
        if (is_string($this->value)) {
            return sprintf("->default('%s')", $this->value);
        } elseif (is_int($this->value)) {
            return sprintf('->default(%d)', $this->value);
        } elseif (is_bool($this->value)) {
            if ($this->value) {
                return '->default(true)';
            }

            return '->default(false)';
        }

        throw new Exception('Not support DefaultModifier value');
    }
}
