<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier;

final class NullableModifier extends ColumnModifier
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'nullable';
    }
}
