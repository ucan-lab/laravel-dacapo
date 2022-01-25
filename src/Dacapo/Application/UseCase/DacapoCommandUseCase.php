<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input\DacapoCommandUseCaseInput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory\ColumnModifierFactory;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory\ColumnTypeFactory;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory\IndexModifierTypeFactory;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\Column;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKeyList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ReferenceAction;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierList;
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
use function is_array;
use function is_bool;
use function is_string;

final class DacapoCommandUseCase
{
    private MigrationGenerator $generator;

    /**
     * DacapoCommandUseCase constructor.
     * @param MigrationGenerator $generator
     */
    public function __construct(
        MigrationGenerator $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * @param DacapoCommandUseCaseInput $input
     * @return DacapoCommandUseCaseOutput
     */
    public function handle(DacapoCommandUseCaseInput $input): DacapoCommandUseCaseOutput
    {
        $list = [];
        foreach ($input->schemaBodies as $tableName => $tableAttributes) {
            $list[] = $this->makeSchema(new TableName($tableName), $tableAttributes);
        }

        $schemaList = new SchemaList($list);
        $migrationFileList = $this->generator->generate($schemaList);

        $migrationBodies = [];
        foreach ($migrationFileList as $migrationFile) {
            $migrationBodies[] = [
                'name' => $migrationFile->getName(),
                'contents' => $migrationFile->getContents(),
            ];
        }

        return new DacapoCommandUseCaseOutput($migrationBodies);
    }

    /**
     * @param TableName $tableName
     * @param array $attributes
     * @return Schema
     */
    private function makeSchema(TableName $tableName, array $attributes): Schema
    {
        try {
            $columnList = $this->makeColumnList($attributes['columns'] ?? []);
            $sqlIndexList = $this->makeIndexModifierList($attributes['indexes'] ?? []);
            $foreignKeyList = $this->makeForeignKeyList($attributes['foreign_keys'] ?? []);
        } catch (InvalidArgumentException $exception) {
            throw new InvalidArgumentException(sprintf('%s.%s', $tableName->getName(), $exception->getMessage()), $exception->getCode(), $exception);
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
     */
    private function makeColumnList(array $columns): ColumnList
    {
        $columnList = [];

        foreach ($columns as $name => $attributes) {
            $columnName = new ColumnName($name);
            $columnModifierList = [];

            if (is_string($attributes)) {
                try {
                    $columnType = ColumnTypeFactory::factory($attributes);
                } catch (InvalidArgumentException $exception) {
                    throw new InvalidArgumentException(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }
            } elseif (is_bool($attributes) || $attributes === null) {
                try {
                    $columnName = new ColumnName('');
                    $columnType = ColumnTypeFactory::factory($name);
                } catch (InvalidArgumentException $exception) {
                    throw new InvalidArgumentException(sprintf('columns.%s', $exception->getMessage()), $exception->getCode(), $exception);
                }
            } elseif (is_array($attributes)) {
                if (isset($attributes['type']) === false) {
                    throw new InvalidArgumentException(sprintf('columns.%s.type field is required', $name));
                }

                try {
                    $columnType = ColumnTypeFactory::factory($attributes['type'], $attributes['args'] ?? null);
                } catch (InvalidArgumentException $exception) {
                    throw new InvalidArgumentException(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }

                unset($attributes['type'], $attributes['args']);

                try {
                    foreach ($attributes as $modifierName => $modifierValue) {
                        $columnModifierList[] = ColumnModifierFactory::factory($modifierName, $modifierValue);
                    }
                } catch (InvalidArgumentException $exception) {
                    throw new InvalidArgumentException(sprintf('columns.%s.%s', $name, $exception->getMessage()), $exception->getCode(), $exception);
                }
            } else {
                throw new InvalidArgumentException(sprintf('columns.%s field is unsupported format', $name));
            }

            $columnList[] = new Column($columnName, $columnType, new ColumnModifierList($columnModifierList));
        }

        return new ColumnList($columnList);
    }

    /**
     * @param array $indexes
     * @return IndexModifierList
     */
    private function makeIndexModifierList(array $indexes): IndexModifierList
    {
        $indexModifierList = [];

        foreach ($indexes as $indexAttributes) {
            if (isset($indexAttributes['columns']) === false) {
                throw new InvalidArgumentException('foreign_keys.columns field is required');
            }

            if (isset($indexAttributes['type']) === false) {
                throw new InvalidArgumentException('foreign_keys.type field is required');
            }

            $columns = $indexAttributes['columns'];
            $indexType = IndexModifierTypeFactory::factory($indexAttributes['type']);
            $name = $indexAttributes['name'] ?? null;
            $algorithm = $indexAttributes['algorithm'] ?? null;

            $indexModifierList[] = new IndexModifier($indexType, $columns, $name, $algorithm);
        }

        return new IndexModifierList($indexModifierList);
    }

    /**
     * @param array $foreignKeys
     * @return ForeignKeyList
     */
    private function makeForeignKeyList(array $foreignKeys): ForeignKeyList
    {
        $foreignKeyList = [];

        foreach ($foreignKeys as $foreignKeyAttribute) {
            if (isset($foreignKeyAttribute['columns']) === false) {
                throw new InvalidArgumentException('foreign_keys.columns field is required');
            }

            if (isset($foreignKeyAttribute['references']) === false) {
                throw new InvalidArgumentException('foreign_keys.references field is required');
            }

            if (isset($foreignKeyAttribute['on']) === false) {
                throw new InvalidArgumentException('foreign_keys.on field is required');
            }

            $reference = new Reference($foreignKeyAttribute['columns'], $foreignKeyAttribute['references'], $foreignKeyAttribute['on'], $foreignKeyAttribute['name'] ?? null);
            $referenceAction = new ReferenceAction($foreignKeyAttribute['onUpdate'] ?? null, $foreignKeyAttribute['onDelete'] ?? null);

            $foreignKeyList[] = new ForeignKey($reference, $referenceAction);
        }

        return new ForeignKeyList($foreignKeyList);
    }
}
