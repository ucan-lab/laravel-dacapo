<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use Exception;

class Index
{
    /**
     * @var IndexType
     */
    protected IndexType $type;

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
     * @param IndexType $type
     * @param string|null $name = null
     * @param string|null $algorithm = null
     */
    public function __construct(IndexType $type, $columns, ?string $name = null, ?string $algorithm = null)
    {
        $this->type = $type;
        $this->columns = $columns;
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    /**
     * @param string|array $attributes
     * @return Index
     * @throws Exception
     */
    public static function factoryFromYaml($attributes): self
    {
        $columns = $attributes['columns'];
        $indexType = self::factoryIndexTypeClass($attributes['type']);
        $name = $attributes['name'] ?? null;
        $algorithm = $attributes['algorithm'] ?? null;

        return new Index($indexType, $columns, $name, $algorithm);
    }

    /**
     * @param string $name
     * @return IndexType
     * @throws Exception
     */
    protected static function factoryIndexTypeClass(string $name): IndexType
    {
        $indexTypeClass = __NAMESPACE__ . '\\IndexType\\' . ucfirst($name) . 'Type';

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
     * @return IndexType
     */
    public function getType(): IndexType
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
