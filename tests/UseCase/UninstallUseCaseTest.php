<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\UseCase;

use UcanLab\LaravelDacapo\App\UseCase\UninstallUseCase;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemasStorage;
use UcanLab\LaravelDacapo\Test\TestCase;

class UninstallUseCaseTest extends TestCase
{
    public function testResolve(): void
    {
        $storage = new InMemorySchemasStorage();

        $this->assertTrue((new UninstallUseCase($storage))->handle());
    }
}
