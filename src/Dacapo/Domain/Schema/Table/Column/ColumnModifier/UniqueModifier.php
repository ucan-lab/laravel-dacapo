<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier;

final class UniqueModifier extends ColumnModifier
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'unique';
    }
}
