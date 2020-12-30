<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\UseCase;

use UcanLab\LaravelDacapo\App\UseCase\Console\DacapoInitCommandUseCase;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Test\TestCase;

class InitUseCaseTest extends TestCase
{
    public function testResolve(): void
    {
        $repository = new InMemorySchemaListRepository();
        $this->assertTrue((new DacapoInitCommandUseCase($repository))->handle('laravel8'));
    }
}
