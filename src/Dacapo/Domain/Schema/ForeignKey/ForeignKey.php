<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

final class ForeignKey
{
    private Reference $reference;
    private ReferenceAction $referenceAction;

    /**
     * ForeignKey constructor.
     * @param Reference $reference
     * @param ReferenceAction $referenceAction
     */
    private function __construct(
        Reference $reference,
        ReferenceAction $referenceAction
    ) {
        $this->reference = $reference;
        $this->referenceAction = $referenceAction;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        return new self(
            Reference::factory($attributes),
            ReferenceAction::factory($attributes)
        );
    }

    /**
     * @return string
     */
    public function createForeignKeyMigrationUpMethod(): string
    {
        return sprintf('$table%s%s;', $this->reference->makeForeignMigration(), $this->referenceAction->makeForeignMigration());
    }

    /**
     * @return string
     */
    public function createForeignKeyMigrationDownMethod(): string
    {
        return sprintf('$table%s;', $this->reference->makeDropForeignMigration());
    }
}
