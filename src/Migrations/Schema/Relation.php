<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class Relation
{
    private $name;
    private $foreign;
    private $references;
    private $on;
    private $onUpdate;
    private $onDelete;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'] ?? null;
        $this->foreign = $attributes['foreign'];
        $this->references = $attributes['references'] ?? 'id';
        $this->on = $attributes['on'];
        $this->onUpdate = $attributes['onUpdate'] ?? null;
        $this->onDelete = $attributes['onDelete'] ?? null;
    }

    /**
     * @return string
     */
    public function getUpForeignKeyLine(): string
    {
        $str = $this->getForeignKey();
        $str .= $this->getForeignKeyModifier();

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    public function getDownForeignKeyLine(): string
    {
        $str = Method::call('dropForeign', $this->name ?: (array) $this->foreign);

        return '$table' . $str . ';';
    }

    /**
     * @return string
     */
    private function getForeignKey(): string
    {
        return implode('', [
            Method::call('foreign', $this->foreign, ...$this->name ? [$this->name] : []),
            Method::call('references', $this->references),
            Method::call('on', $this->on),
        ]);
    }

    /**
     * @return string
     */
    private function getForeignKeyModifier(): string
    {
        $str = '';

        if ($this->onUpdate) {
            $str .= Method::call('onUpdate', $this->onUpdate);
        }

        if ($this->onDelete) {
            $str .= Method::call('onDelete', $this->onDelete);
        }

        return $str;
    }
}
