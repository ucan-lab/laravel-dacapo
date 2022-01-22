<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use Exception;

class IndexModifier
{
    /**
     * @var IndexModifierType
     */
    protected IndexModifierType $type;

    /**
     * @var string|array
     */
    protected $columns;

    /**
     * @var string|null
     */
    protected ?string $name;

    /**
     * @var string|null
     */
    protected ?string $algorithm;

    /**
     * Index constructor.
     * @param string|array $columns
     * @param IndexModifierType $type
     * @param string|null $name = null
     * @param string|null $algorithm = null
     */
    public function __construct(IndexModifierType $type, $columns, ?string $name = null, ?string $algorithm = null)
    {
        $this->type = $type;
        $this->columns = $columns;
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    /**
     * @return string
     * @throws
     */
    public function createIndexMigrationUpMethod(): string
    {
        if ($this->hasArgs()) {
            return '$table->' . sprintf('%s(%s, %s);', $this->type->getUpMethodName(), $this->getColumns(), $this->makeArgs());
        }

        return '$table->' . sprintf('%s(%s);', $this->type->getUpMethodName(), $this->getColumns());
    }

    /**
     * @return string
     */
    public function createIndexMigrationDownMethod(): string
    {
        if ($this->name) {
            return '$table->' . sprintf("%s('%s');", $this->type->getDownMethodName(), $this->name);
        } elseif (is_array($this->columns)) {
            return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), implode("', '", $this->columns));
        }

        return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), $this->columns);
    }

    /**
     * @return string
     */
    protected function getColumns(): string
    {
        if (is_array($this->columns)) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("'%s'", $this->columns);
    }

    /**
     * @return bool
     */
    protected function hasArgs(): bool
    {
        if ($this->name) {
            return true;
        }

        if ($this->algorithm) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function makeArgs(): string
    {
        if ($this->name && $this->algorithm) {
            return sprintf("'%s', '%s'", $this->name, $this->algorithm);
        } elseif (empty($this->name) && $this->algorithm) {
            return sprintf("null, '%s'", $this->algorithm);
        } elseif ($this->name && empty($this->algorithm)) {
            return sprintf("'%s'", $this->name);
        }

        throw new Exception('Has no args.');
    }
}
