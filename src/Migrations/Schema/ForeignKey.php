<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

class ForeignKey
{
    private $name;
    private $foreign;
    private $references;
    private $on;
    private $onUpdate;
    private $onDelete;

    public function __construct(array $attributes)
    {
        $this->name = $attributes['name'] ?? null;
        $this->foreign = $attributes['foreign'];
        $this->references = $attributes['references'];
        $this->on = $attributes['on'];
        $this->onUpdate = $attributes['onUpdate'] ?? null;
        $this->onDelete = $attributes['onDelete'] ?? null;
    }

    public function getUpForeignKeyLine(): string
    {
        $str = $this->getForeignKey();
        $str .= $this->getForeignKeyModifier();

        return '$table' . $str . ';';
    }

    public function getDownForeignKeyLine(): string
    {
        $str = "->dropForeign(['$this->foreign'])";

        return '$table' . $str . ';';
    }

    private function getForeignKey(): string
    {
        return sprintf(
            "->foreign('%s')->references('%s')->on('%s')",
            $this->foreign,
            $this->references,
            $this->on
        );
    }

    private function getForeignKeyModifier(): string
    {
        $str = '';

        if ($this->onUpdate) {
            $str .= "->onUpdate('$this->onUpdate')";
        } elseif ($this->onDelete) {
            $str .= "->onDelete('$this->onDelete')";
        }

        return $str;
    }
}
