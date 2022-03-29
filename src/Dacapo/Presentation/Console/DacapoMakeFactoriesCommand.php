<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\DacapoMakeFactoriesCommandUseCase;

/**
 * Class DacapoMakeFactoriesCommand.
 */
final class DacapoMakeFactoriesCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dacapo:make:factories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate factories class from schemas.';

    /**
     * @param DacapoMakeFactoriesCommandUseCase $useCase
     */
    public function handle(
        DacapoMakeFactoriesCommandUseCase $useCase,
    ): void {
        $output = $useCase->handle();
        $tableNameList = $this->removeIgnoreTableNames($output->tableNameList);

        foreach ($tableNameList as $tableName) {
            $factoryName = $this->makeFactoryName($tableName);

            $this->comment(sprintf('php artisan make:factory %s', $factoryName));

            $this->call('make:factory', [
                'name' => $factoryName,
            ]);
        }
    }

    /**
     * @param string $tableName
     * @return string
     */
    private function makeFactoryName(string $tableName): string
    {
        return Str::studly(Str::singular($tableName)) . 'Factory';
    }

    /**
     * @param array<int, string> $tableNameList
     * @return array<int, string>
     */
    private function removeIgnoreTableNames(array $tableNameList): array
    {
        $ignoreTableNameList = config('dacapo.ignore_tables', [
            'users',
            'password_resets',
            'failed_jobs',
            'personal_access_tokens',
        ]);

        return array_diff($tableNameList, $ignoreTableNameList);
    }
}
