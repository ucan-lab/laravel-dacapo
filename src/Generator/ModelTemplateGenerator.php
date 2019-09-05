<?php

namespace UcanLab\LaravelDacapo\Generator;

use Illuminate\Support\Facades\Artisan;
use UcanLab\LaravelDacapo\Storage\Storage;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;

class ModelTemplateGenerator
{
    private $tables;
    private $modelsStorage;
    private $dir;

    /**
     * ModelTemplateGenerator constructor.
     * @param Tables $tables
     * @param Storage $modelsStorage
     * @param string|null $dir
     */
    public function __construct(Tables $tables, Storage $modelsStorage, ?string $dir = null)
    {
        $this->tables = $tables;
        $this->modelsStorage = $modelsStorage;
        $this->dir = $dir;
    }

    public function run(): void
    {
        foreach ($this->tables as $table) {
            $modelName = ($this->dir ? "$this->dir/" : '') . $table->getModelName();
            if (! $this->modelsStorage->exists($modelName . '.php')) {
                Artisan::call('make:model', [
                    'name' => $modelName,
                ]);
            }
        }
    }
}
