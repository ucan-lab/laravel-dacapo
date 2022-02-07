<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Test\TestCase;

final class IndexTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param string|array<int, string> $columns
     * @param string|null $name
     * @param string|null $algorithm
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $columns, ?string $name, ?string $algorithm): void
    {
        $index = IndexModifier::factory([
            'type' => 'index',
            'columns' => $columns,
            'name' => $name,
            'algorithm' => $algorithm,
        ]);

        $this->assertSame($expected, $index->createIndexMigrationUpMethod());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataResolve(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->index(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
                'algorithm' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->index('test');",
                'columns' => 'test',
                'name' => null,
                'algorithm' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->index('test', 'test_alias_index');",
                'columns' => 'test',
                'name' => 'test_alias_index',
                'algorithm' => null,
            ],
        ];
    }

    /**
     * @param string $expected
     * @param string|array<int, string> $columns
     * @param string|null $name
     * @dataProvider dataCreateIndexMigrationDownMethod
     */
    public function testCreateIndexMigrationDownMethod(string $expected, $columns, ?string $name): void
    {
        $index = IndexModifier::factory([
            'type' => 'index',
            'columns' => $columns,
            'name' => $name,
        ]);

        $this->assertSame($expected, $index->createIndexMigrationDownMethod());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataCreateIndexMigrationDownMethod(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->dropIndex(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->dropIndex(['test']);",
                'columns' => 'test',
                'name' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->dropIndex('test_alias_index');",
                'columns' => 'test',
                'name' => 'test_alias_index',
            ],
        ];
    }
}
