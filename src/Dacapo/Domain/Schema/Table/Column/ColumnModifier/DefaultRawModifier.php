<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier;

/**
 * DefaultRawModifier class is original ColumnModifier class
 */
final class DefaultRawModifier extends ColumnModifier implements DbFacadeUsing
{
    public function getName(): string
    {
        return 'default';
    }
}
