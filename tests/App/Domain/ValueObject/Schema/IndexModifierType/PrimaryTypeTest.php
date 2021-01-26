<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifier;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\IndexModifierType\PrimaryType;
use UcanLab\LaravelDacapo\Test\TestCase;

class PrimaryTypeTest extends TestCase
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
        $indexType = new PrimaryType();
        $index = new IndexModifier($indexType, $columns, $name, $algorithm);
        $this->assertSame($expected, $index->createIndexMigrationUpMethod());
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->primary(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
                'algorithm' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->primary('test');",
                'columns' => 'test',
                'name' => null,
                'algorithm' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->primary('test', 'test_alias_index');",
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
        $indexType = new PrimaryType();
        $index = new IndexModifier($indexType, $columns, $name);
        $this->assertSame($expected, $index->createIndexMigrationDownMethod());
    }

    /**
     * @return array
     */
    public function dataCreateIndexMigrationDownMethod(): array
    {
        return [
            'columns:test1,test2' => [
                'expected' => '$table' . "->dropPrimary(['test1', 'test2']);",
                'columns' => ['test1', 'test2'],
                'name' => null,
            ],
            'name:null' => [
                'expected' => '$table' . "->dropPrimary(['test']);",
                'columns' => 'test',
                'name' => null,
            ],
            'name:test_alias_index' => [
                'expected' => '$table' . "->dropPrimary('test_alias_index');",
                'columns' => 'test',
                'name' => 'test_alias_index',
            ],
        ];
    }
}
