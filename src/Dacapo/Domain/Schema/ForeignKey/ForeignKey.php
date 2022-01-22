<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

class ForeignKey
{
    protected Reference $reference;
    protected ReferenceAction $referenceAction;

    /**
     * ForeignKey constructor.
     * @param Reference $reference
     * @param ReferenceAction $referenceAction
     */
    public function __construct(
        Reference $reference,
        ReferenceAction $referenceAction
    ) {
        $this->reference = $reference;
        $this->referenceAction = $referenceAction;
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
