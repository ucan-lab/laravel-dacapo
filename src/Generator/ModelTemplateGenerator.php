<?php

namespace UcanLab\LaravelDacapo\Generator;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Migrations\Schema\Tables;

class ModelTemplateGenerator
{
    private $tables;

    public function __construct(Tables $tables)
    {
        $this->tables = $tables;
    }

    public function run(): void
    {
        foreach ($this->tables as $table) {
            if (! $this->existsModel($table->getModelName())) {
                Artisan::call('make:model', [
                    'name' => $table->getModelName(),
                ]);
            }
        }
    }

    /**
     * @return string
     */
    private function getModelPath(): string
    {
        return app_path();
    }

    private function existsModel(string $modelName): bool
    {
        return File::exists($this->getModelPath() . '/' . $modelName . '.php');
    }
}
