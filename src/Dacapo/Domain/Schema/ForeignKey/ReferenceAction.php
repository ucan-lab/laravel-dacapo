<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

final class ReferenceAction
{
    /**
     * Reference constructor.
     */
    private function __construct(
        private ?string $onUpdateAction,
        private ?string $onDeleteAction,
    ) {
    }

    /**
     * @param array<string, string> $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        return new self(
            $attributes['onUpdateAction'] ?? null,
            $attributes['onDeleteAction'] ?? null,
        );
    }

    public function makeForeignMigration(): string
    {
        $str = '';

        if ($this->onUpdateAction) {
            $str .= sprintf("->onUpdate('%s')", $this->onUpdateAction);
        }

        if ($this->onDeleteAction) {
            $str .= sprintf("->onDelete('%s')", $this->onDeleteAction);
        }

        return $str;
    }
}
