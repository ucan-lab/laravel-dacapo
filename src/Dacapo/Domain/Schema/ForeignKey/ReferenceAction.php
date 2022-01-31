<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

final class ReferenceAction
{
    private ?string $onUpdateAction;
    private ?string $onDeleteAction;

    /**
     * Reference constructor.
     * @param string|null $onUpdateAction
     * @param string|null $onDeleteAction
     */
    private function __construct(?string $onUpdateAction, ?string $onDeleteAction)
    {
        $this->onUpdateAction = $onUpdateAction;
        $this->onDeleteAction = $onDeleteAction;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        return new self(
            $attributes['onUpdate'] ?? null,
            $attributes['onDelete'] ?? null
        );
    }

    /**
     * @return string
     */
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
