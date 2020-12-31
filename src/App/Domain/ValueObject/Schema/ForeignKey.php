<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use Exception;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ForeignKey\ReferenceAction;

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
     * @param string|array $attributes
     * @return ForeignKey
     * @throws Exception
     */
    public static function factoryFromYaml($attributes): self
    {
        $reference = new Reference($attributes['columns'], $attributes['references'], $attributes['on'], $attributes['name'] ?? null);
        $referenceAction = new ReferenceAction($attributes['onUpdate'] ?? null, $attributes['onDelete'] ?? null);

        return new ForeignKey($reference, $referenceAction);
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