<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\SqlIndexType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndex;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SqlIndexType\IndexType;
use UcanLab\LaravelDacapo\Test\TestCase;

class IndexTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param string|array $columns
     * @param string|null $name
     * @param string|null $algorithm
     * @dataProvider dataResolve
     */
    public function testResolve(string $expected, $columns, ?string $name, ?string $algorithm): void
    {
        $indexType = new IndexType();
        $index = new SqlIndex($indexType, $columns, $name, $algorithm);
        $this->assertSame($expected, $index->createIndexMigrationUpMethod());
    }

    /**
     * @return array
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
     * @param string|array $columns
     * @param string|null $name
     * @dataProvider dataCreateIndexMigrationDownMethod
     */
    public function testCreateIndexMigrationDownMethod(string $expected, $columns, ?string $name): void
    {
        $indexType = new IndexType();
        $index = new SqlIndex($indexType, $columns, $name);
        $this->assertSame($expected, $index->createIndexMigrationDownMethod());
    }

    /**
     * @return array
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
