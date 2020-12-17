<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\UseCase;

use UcanLab\LaravelDacapo\App\UseCase\Console\DacapoInitCommandUseCase;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemasStorage;
use UcanLab\LaravelDacapo\Test\TestCase;

class InitUseCaseTest extends TestCase
{
    public function testResolve(): void
    {
        $storage = new InMemorySchemasStorage();
        $this->assertTrue((new DacapoInitCommandUseCase($storage))->handle('laravel8'));
    }
}
