<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

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
