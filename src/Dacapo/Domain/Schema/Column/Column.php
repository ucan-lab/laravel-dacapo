<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\DbFacadeUsing;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnType;

final class Column
{
    private ColumnName $name;
    private ColumnType $type;
    private ColumnModifierList $modifierList;

    /**
     * Column constructor.
     * @param ColumnName $name
     * @param ColumnType $type
     * @param ColumnModifierList $modifierList
     */
    public function __construct(
        ColumnName $name,
        ColumnType $type,
        ColumnModifierList $modifierList
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->modifierList = $modifierList;
    }

    /**
     * @return string
     */
    public function createColumnMigration(): string
    {
        $typeMethod = $this->type->createMigrationMethod($this->name);

        $modifierMethod = '';

        foreach ($this->modifierList as $modifier) {
            $modifierMethod .= $modifier->createMigrationMethod();
        }

        return sprintf('$table%s%s;', $typeMethod, $modifierMethod);
    }

    /**
     * @return bool
     */
    public function isDbFacadeUsing(): bool
    {
        foreach ($this->modifierList as $modifier) {
            if ($modifier instanceof DbFacadeUsing) {
                return true;
            }
        }

        return false;
    }
}
