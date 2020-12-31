<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use Exception;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;

class DacapoInitCommandUseCase
{
    protected SchemaListRepository $repository;

    protected array $supportVersions = [
        'laravel6',
        'laravel7',
        'laravel8',
    ];

    /**
     * DacapoInitCommandUseCase constructor.
     * @param SchemaListRepository $repository
     */
    public function __construct(SchemaListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $version
     * @return bool
     * @throws
     */
    public function handle(string $version): bool
    {
        $this->validateVersion($version);

        $this->repository->init();
        $this->repository->saveFile($this->makeSchemaFile($version));

        return true;
    }

    /**
     * @param string $version
     * @throws Exception
     */
    protected function validateVersion(string $version): void
    {
        if (in_array($version, $this->supportVersions, true) === false) {
            throw new Exception('An unsupported version is specified.');
        }
    }

    /**
     * @param string $version
     * @return SchemaFile
     */
    protected function makeSchemaFile(string $version): SchemaFile
    {
        $path = sprintf('%s/../../../Infra/Storage/default-schemas/%s.yml', __DIR__, $version);

        return new SchemaFile('default.yml', file_get_contents($path));
    }
}
