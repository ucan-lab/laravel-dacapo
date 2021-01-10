<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

class Temporary
{
    protected bool $enable;

    /**
     * Temporary constructor.
     * @param bool $enable
     */
    public function __construct(bool $enable)
    {
        $this->enable = $enable;
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
