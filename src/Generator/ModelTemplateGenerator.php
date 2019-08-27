<?php

namespace UcanLab\LaravelDacapo\Generator;

use Illuminate\Support\Facades\Artisan;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;
use UcanLab\LaravelDacapo\Storage\Storage;

class ModelTemplateGenerator
{
    private $tables;
    private $modelsStorage;

    public function __construct(Tables $tables, Storage $modelsStorage)
    {
        $this->tables = $tables;
        $this->modelsStorage = $modelsStorage;
    }

    public function run(): void
    {
        foreach ($this->tables as $table) {
            if (! $this->modelsStorage->exists($table->getModelName() . '.php')) {
                Artisan::call('make:model', [
                    'name' => $table->getModelName(),
                ]);
            }
        }
    }
}
