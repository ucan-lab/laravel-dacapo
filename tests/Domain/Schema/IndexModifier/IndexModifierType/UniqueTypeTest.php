<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Test\TestCase;

final class UniqueTypeTest extends TestCase
{
    /**
     * @param string|array<int, string> $columns
     * @dataProvider dataResolve
     */
    public function testResolve(
        string $expected,
        string|array $columns,
        ?string $name,
        ?string $algorithm,
    ): void {
        $indexModifier = IndexModifier::factory([
            'type' => 'unique',
            'columns' => $columns,
            'name' => $name,
            'algorithm' => $algorithm,
        ]);

        $this->assertSame($expected, $indexModifier->makeUpMigration());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataResolve(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->unique(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
                'algorithm' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->unique('test');",
                'columns' => 'test',
                'name' => null,
                'algorithm' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->unique('test', 'test_alias_index');",
                'columns' => 'test',
                'name' => 'test_alias_index',
                'algorithm' => null,
            ],
        ];
    }

    /**
     * @param array<int, string>|string $columns
     * @dataProvider dataCreateIndexMigrationDownMethod
     */
    public function testCreateIndexMigrationDownMethod(
        string $expected,
        array|string $columns,
        ?string $name,
    ): void {
        $indexModifier = IndexModifier::factory([
            'type' => 'unique',
            'columns' => $columns,
            'name' => $name,
        ]);
        $this->assertSame($expected, $indexModifier->makeDownMigration());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataCreateIndexMigrationDownMethod(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->dropUnique(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->dropUnique(['test']);",
                'columns' => 'test',
                'name' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->dropUnique('test_alias_index');",
                'columns' => 'test',
                'name' => 'test_alias_index',
            ],
        ];
    }
}
