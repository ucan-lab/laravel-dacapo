<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\DacapoMakeModelsCommandUseCase;

/**
 * Class DacapoCommand.
 */
final class DacapoMakeModelsCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:make:models
        {--force : Create the class even if the model already exists}
        {--c|controller : Create a new controller for the model}
        {--f|factory : Create a new factory for the model}
        {--policy : Create a new policy for the model}
        {--s|seed : Create a new seeder for the model}
        {--p|pivot : Indicates if the generated model should be a custom intermediate table model}
        {--r|resource : Indicates if the generated controller should be a resource controller}
        {--api : Indicates if the generated controller should be an API controller}
        {--R|requests : Create new form request classes and use them in the resource controller}
        {--test : Generate an accompanying PHPUnit test for the Model}
        {--pest : Generate an accompanying Pest test for the Model}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate models class from schemas.';

    /**
     * @param DacapoMakeModelsCommandUseCase $useCase
     */
    public function handle(
        DacapoMakeModelsCommandUseCase $useCase,
    ): void {
        $output = $useCase->handle();
        $tableNameList = $this->removeIgnoreTableNames($output->tableNameList);

        foreach ($tableNameList as $tableName) {
            $modelName = $this->makeModelName($tableName);

            $this->comment(sprintf('php artisan make:model%s%s%s%s%s%s%s%s%s%s %s',
                $this->option('controller') ? ' --controller' : '',
                $this->option('factory') ? ' --factory' : '',
                $this->option('force') ? ' --force' : '',
                $this->option('policy') ? ' --policy' : '',
                $this->option('seed') ? ' --seed' : '',
                $this->option('resource') ? ' --resource' : '',
                $this->option('api') ? ' --api' : '',
                $this->option('requests') ? ' --requests' : '',
                $this->option('test') ? ' --test' : '',
                $this->option('pest') ? ' --pest' : '',
                $modelName
            ));

            $this->call('make:model', [
                'name' => $modelName,
                '--controller' => $this->option('controller'),
                '--factory' => $this->option('factory'),
                '--force' => $this->option('force'),
                '--policy' => $this->option('policy'),
                '--seed' => $this->option('seed'),
                '--resource' => $this->option('resource'),
                '--api' => $this->option('api'),
                '--requests' => $this->option('requests'),
                '--test' => $this->option('test'),
                '--pest' => $this->option('pest'),
            ]);
        }
    }

    /**
     * @param string $tableName
     * @return string
     */
    private function makeModelName(string $tableName): string
    {
        return Str::studly(Str::singular($tableName));
    }

    /**
     * @param array<int, string> $tableNameList
     * @return array<int, string>
     */
    private function removeIgnoreTableNames(array $tableNameList): array
    {
        $ignoreTableNameList = [
            'users',
            'password_resets',
            'failed_jobs',
        ];

        return array_diff($tableNameList, $ignoreTableNameList);
    }
}
