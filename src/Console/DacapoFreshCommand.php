<?php

namespace UcanLab\LaravelDacapo\Console;

/**
 * Class DacapoFreshCommand.
 */
class DacapoFreshCommand extends DacapoCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:fresh
        {--no-migrate : Do not migrate}
        {--seed : Seed the database with records}
    ';
}
