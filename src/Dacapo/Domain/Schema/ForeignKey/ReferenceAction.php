<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

final class ReferenceAction
{
    /**
     * Reference constructor.
     * @param string|null $onUpdateAction
     * @param string|null $onDeleteAction
     */
    private function __construct(
        private ?string $onUpdateAction,
        private ?string $onDeleteAction
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        $onUpdateAction = null;
        $onDeleteAction = null;

        if (isset($attributes['onUpdateAction'])) {
            $onUpdateAction = $attributes['onUpdateAction'];
        }

        if (isset($attributes['onDeleteAction'])) {
            $onDeleteAction = $attributes['onDeleteAction'];
        }

        return new self(
            $onUpdateAction,
            $onDeleteAction
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
