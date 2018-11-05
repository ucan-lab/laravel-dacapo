<?php

namespace UcanLab\LaravelDacapo\Console;

use Illuminate\Console\Command;

/**
 * Class SchemaGenerate
 */
class SchemaGenerate extends Command
{
    /** @var string */
    protected $name = 'dacapo:schema:generate';

    /** @var string */
    protected $description = 'Generate migration files.';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('schema generated.');
    }
}
