<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use Exception;

class SqlIndex
{
    /**
     * @var SqlIndexType
     */
    protected SqlIndexType $type;

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
     * @param SqlIndexType $type
     * @param string|null $name = null
     * @param string|null $algorithm = null
     */
    public function __construct(SqlIndexType $type, $columns, ?string $name = null, ?string $algorithm = null)
    {
        $this->type = $type;
        $this->columns = $columns;
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    /**
     * @param string|array $attributes
     * @return SqlIndex
     * @throws Exception
     */
    public static function factoryFromYaml($attributes): self
    {
        $columns = $attributes['columns'];
        $indexType = self::factorySqlIndexTypeClass($attributes['type']);
        $name = $attributes['name'] ?? null;
        $algorithm = $attributes['algorithm'] ?? null;

        return new SqlIndex($indexType, $columns, $name, $algorithm);
    }

    /**
     * @param string $name
     * @return SqlIndexType
     * @throws Exception
     */
    protected static function factorySqlIndexTypeClass(string $name): SqlIndexType
    {
        $indexTypeClass = __NAMESPACE__ . '\\SqlIndexType\\' . ucfirst($name) . 'Type';

        if (class_exists($indexTypeClass)) {
            return new $indexTypeClass();
        }

        throw new Exception(sprintf('%s class not found exception.', $indexTypeClass));
    }

    /**
     * @return string
     */
    public function createIndexMigrationUpMethod(): string
    {
        $typeMethod = $this->type->createIndexMigrationUpMethod($this);

        return sprintf('$table%s;', $typeMethod);
    }

    /**
     * @return string
     */
    public function createIndexMigrationDownMethod(): string
    {
        $typeMethod = $this->type->createIndexMigrationDownMethod($this);

        return sprintf('$table%s;', $typeMethod);
    }

    /**
     * @return SqlIndexType
     */
    public function getType(): SqlIndexType
    {
        return $this->type;
    }

    /**
     * @return string|array
     * @throws
     */
    public function getColumns(): string
    {
        if (is_array($this->columns)) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("['%s']", $this->columns);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getAlgorithm(): ?string
    {
        return $this->algorithm;
    }
}
