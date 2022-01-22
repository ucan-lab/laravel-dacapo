<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input\DacapoCommandUseCaseInput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ReferenceAction;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Charset;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Collation;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Connection;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Engine;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Table;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableComment;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Temporary;
use function is_string;
use function is_bool;
use function is_array;

final class DacapoCommandUseCase
{
    protected MigrationGenerator $generator;

    /**
     * DacapoCommandUseCase constructor.
     * @param MigrationGenerator $generator
     */
    public function __construct(MigrationGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param DacapoCommandUseCaseInput $input
     * @return DacapoCommandUseCaseOutput
     * @throws Exception
     */
    public function handle(DacapoCommandUseCaseInput $input): DacapoCommandUseCaseOutput
    {
        $schemaList = new SchemaList();

        foreach ($input->schemaFiles as $tableName => $tableAttributes) {
            $schemaList->add($this->makeSchema($tableName, $tableAttributes));
        }

        $migrationFileList = $this->generator->generate($schemaList);

        return new DacapoCommandUseCaseOutput($migrationFileList);
    }

    /**
     * @param string $name
     * @param array $attributes
     * @return Schema
     * @throws Exception
     */
    private function makeSchema(string $name, array $attributes): Schema
    {
        $tableName = new TableName($name);

        try {
            $columnList = $this->makeColumnList($attributes['columns'] ?? []);
            $sqlIndexList = $this->makeIndexModifierList($attributes['indexes'] ?? []);
            $foreignKeyList = $this->makeForeignKeyList($attributes['foreign_keys'] ?? []);
        } catch (Exception $exception) {
            throw new Exception(sprintf('%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
        }

        $connection = new Connection($attributes['connection'] ?? null);
        $tableComment = new TableComment($attributes['comment'] ?? null);
        $engine = new Engine($attributes['engine'] ?? null);
        $charset = new Charset($attributes['charset'] ?? null);
        $collation = new Collation($attributes['collation'] ?? null);
        $temporary = new Temporary($attributes['temporary'] ?? false);

        $table = new Table(
            $connection,
            $tableName,
            $tableComment,
            $engine,
            $charset,
            $collation,
            $temporary
        );

        return new Schema(
            $table,
            $columnList,
            $sqlIndexList,
            $foreignKeyList
        );
    }

    /**
     * @param array $columns
     * @return ColumnList
     * @throws Exception
     */
    private function makeColumnList(array $columns): ColumnList
    {
        $columnList = new ColumnList();

        foreach ($columns as $name => $attributes) {
            $columnName = new ColumnName($name);
            $modifierList = new ColumnModifierList();

            if (is_string($attributes)) {
                try {
                    $columnType = $this->makeColumnTypeClass($attributes);
                } catch (Exception $exception) {
                    throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }
            } elseif (is_bool($attributes) || $attributes === null) {
                try {
                    $columnName = new ColumnName('');
                    $columnType = $this->makeColumnTypeClass($name);
                } catch (Exception $exception) {
                    throw new Exception(sprintf('columns.%s', $exception->getMessage()), $exception->getCode(), $exception);
                }
            } elseif (is_array($attributes)) {
                if (isset($attributes['type']) === false) {
                    throw new Exception(sprintf('columns.%s.type field is required', $name));
                }

                try {
                    $columnType = $this->makeColumnTypeClass($attributes['type'], $attributes['args'] ?? null);
                } catch (Exception $exception) {
                    throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }

                unset($attributes['type'], $attributes['args']);

                try {
                    foreach ($attributes as $modifierName => $modifierValue) {
                        $modifierList->add($this->makeColumnModifierClass($modifierName, $modifierValue));
                    }
                } catch (Exception $exception) {
                    throw new Exception(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }
            } else {
                throw new Exception(sprintf('columns.%s field is unsupported format', $name));
            }

            $columnList->add(new Column($columnName, $columnType, $modifierList));
        }

        return $columnList;
    }

    /**
     * @param string $name
     * @param $args
     * @return ColumnType
     * @throws Exception
     */
    private function makeColumnTypeClass(string $name, $args = null): ColumnType
    {
        $columnTypeClass = 'UcanLab\\LaravelDacapo\\Dacapo\\Domain\\Schema\\Column\\ColumnType\\' . ucfirst($name) . 'Type';

        if (class_exists($columnTypeClass)) {
            if ($args !== null) {
                return new $columnTypeClass($args);
            }

            return new $columnTypeClass();
        }

        throw new Exception(sprintf('%s column type does not exist', $name));
    }

    /**
     * @param string $name
     * @param $value
     * @return ColumnModifier
     * @throws Exception
     */
    private function makeColumnModifierClass(string $name, $value): ColumnModifier
    {
        $columnModifierClass = 'UcanLab\\LaravelDacapo\\Dacapo\\Domain\\Schema\\Column\\ColumnModifier\\' . ucfirst($name) . 'Modifier';

        if (class_exists($columnModifierClass)) {
            return new $columnModifierClass($value);
        }

        throw new Exception(sprintf('%s column modifier does not exist', $name));
    }

    /**
     * @param array $indexes
     * @return IndexModifierList
     * @throws Exception
     */
    private function makeIndexModifierList(array $indexes): IndexModifierList
    {
        $sqlIndexList = new IndexModifierList();

        foreach ($indexes as $indexAttributes) {
            if (isset($indexAttributes['columns']) === false) {
                throw new Exception('foreign_keys.columns field is required');
            }

            if (isset($indexAttributes['type']) === false) {
                throw new Exception('foreign_keys.type field is required');
            }

            $columns = $indexAttributes['columns'];
            $indexType = $this->makeIndexModifierTypeClass($indexAttributes['type']);
            $name = $indexAttributes['name'] ?? null;
            $algorithm = $indexAttributes['algorithm'] ?? null;

            $sqlIndex = new IndexModifier($indexType, $columns, $name, $algorithm);

            $sqlIndexList->add($sqlIndex);
        }

        return $sqlIndexList;
    }

    /**
     * @param string $name
     * @return IndexModifierType
     * @throws Exception
     */
    private function makeIndexModifierTypeClass(string $name): IndexModifierType
    {
        $indexTypeClass = 'UcanLab\\LaravelDacapo\\Dacapo\\Domain\\Schema\\IndexModifier\\IndexModifierType\\' . ucfirst($name) . 'Type';

        if (class_exists($indexTypeClass)) {
            return new $indexTypeClass();
        }

        throw new Exception(sprintf('%s class not found exception.', $indexTypeClass));
    }

    /**
     * @param array $foreignKeys
     * @return ForeignKeyList
     * @throws Exception
     */
    private function makeForeignKeyList(array $foreignKeys): ForeignKeyList
    {
        $foreignKeyList = new ForeignKeyList();

        foreach ($foreignKeys as $foreignKeyAttribute) {
            if (isset($foreignKeyAttribute['columns']) === false) {
                throw new Exception('foreign_keys.columns field is required');
            }

            if (isset($foreignKeyAttribute['references']) === false) {
                throw new Exception('foreign_keys.references field is required');
            }

            if (isset($foreignKeyAttribute['on']) === false) {
                throw new Exception('foreign_keys.on field is required');
            }

            $reference = new Reference($foreignKeyAttribute['columns'], $foreignKeyAttribute['references'], $foreignKeyAttribute['on'], $foreignKeyAttribute['name'] ?? null);
            $referenceAction = new ReferenceAction($foreignKeyAttribute['onUpdate'] ?? null, $foreignKeyAttribute['onDelete'] ?? null);

            $foreign = new ForeignKey($reference, $referenceAction);
            $foreignKeyList->add($foreign);
        }

        return $foreignKeyList;
    }
}
