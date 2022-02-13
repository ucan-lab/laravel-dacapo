<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table;

final class Temporary
{
    /**
     * Temporary constructor.
     * @param bool $enable
     */
    public function __construct(private bool $enable)
    {
    }

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable;
    }

    /**
     * @return string
     */
    public function makeMigration(): string
    {
        return '$table->temporary();';
    }
}
