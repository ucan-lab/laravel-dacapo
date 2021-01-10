<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey\ReferenceAction;

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
        if (isset($attributes['columns']) === false) {
            throw new Exception('foreign_keys.columns field is required');
        }

        if (isset($attributes['references']) === false) {
            throw new Exception('foreign_keys.references field is required');
        }

        if (isset($attributes['on']) === false) {
            throw new Exception('foreign_keys.on field is required');
        }

        $reference = new Reference($attributes['columns'], $attributes['references'], $attributes['on'], $attributes['name'] ?? null);
        $referenceAction = new ReferenceAction($attributes['onUpdate'] ?? null, $attributes['onDelete'] ?? null);

        return new self($reference, $referenceAction);
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
