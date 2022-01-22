<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier\ColumnModifierList;

class Column
{
    protected ColumnName $name;
    protected ColumnType $type;
    protected ColumnModifierList $modifierList;

    /**
     * Column constructor.
     * @param ColumnName $name
     * @param ColumnType $type
     * @param ColumnModifierList $modifierList
     */
    public function __construct(ColumnName $name, ColumnType $type, ColumnModifierList $modifierList)
    {
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
     * @return ColumnModifierList
     */
    public function getColumnModifierList(): ColumnModifierList
    {
        return $this->modifierList;
    }
}
