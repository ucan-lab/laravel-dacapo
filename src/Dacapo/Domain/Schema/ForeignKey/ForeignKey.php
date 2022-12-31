<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

final class ForeignKey
{
    /**
     * ForeignKey constructor.
     */
    private function __construct(
        private Reference $reference,
        private ReferenceAction $referenceAction,
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        return new self(
            Reference::factory($attributes),
            ReferenceAction::factory($attributes)
        );
    }

    public function makeUpMigration(): string
    {
        return sprintf('$table%s%s;', $this->reference->makeForeignMigration(), $this->referenceAction->makeForeignMigration());
    }

    public function makeDownMigration(): string
    {
        return sprintf('$table%s;', $this->reference->makeDropForeignMigration());
    }
}
