<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\UseCase;

use UcanLab\LaravelDacapo\App\UseCase\Console\DacapoUninstallCommandUseCase;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Test\TestCase;

class UninstallUseCaseTest extends TestCase
{
    public function testResolve(): void
    {
        $repository = new InMemorySchemaListRepository();

        $this->assertTrue((new DacapoUninstallCommandUseCase($repository))->handle());
    }
}
