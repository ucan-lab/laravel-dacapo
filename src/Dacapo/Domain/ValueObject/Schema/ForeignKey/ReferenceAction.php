<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey;

class ReferenceAction
{
    protected ?string $onUpdateAction;
    protected ?string $onDeleteAction;

    /**
     * Reference constructor.
     * @param string|null $onUpdateAction
     * @param string|null $onDeleteAction
     */
    public function __construct(?string $onUpdateAction, ?string $onDeleteAction)
    {
        $this->onUpdateAction = $onUpdateAction;
        $this->onDeleteAction = $onDeleteAction;
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
