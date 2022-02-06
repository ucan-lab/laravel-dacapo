<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

final class UseCurrentOnUpdateModifier extends ColumnModifier
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'useCurrentOnUpdate';
    }
}
