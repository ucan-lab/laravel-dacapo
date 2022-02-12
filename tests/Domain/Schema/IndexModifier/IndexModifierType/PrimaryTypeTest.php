<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\IndexModifier\IndexModifierType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifier;
use UcanLab\LaravelDacapo\Test\TestCase;

final class PrimaryTypeTest extends TestCase
{
    /**
     * @param string $expected
     * @param string|array<int, string> $columns
     * @param string|null $name
     * @param string|null $algorithm
     * @dataProvider dataResolve
     */
    public function testResolve(
        string $expected,
        string|array $columns,
        ?string $name,
        ?string $algorithm
    ): void {
        $indexModifier = IndexModifier::factory([
            'type' => 'primary',
            'columns' => $columns,
            'name' => $name,
            'algorithm' => $algorithm,
        ]);

        $this->assertSame($expected, $indexModifier->createIndexMigrationUpMethod());
    }

    /**
     * @return array<string, array<string, mixed>>
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
     * @param array<int, string>|string $columns
     * @param string|null $name
     * @dataProvider dataCreateIndexMigrationDownMethod
     */
    public function testCreateIndexMigrationDownMethod(
        string $expected,
        array|string $columns,
        ?string $name
    ): void {
        $indexModifier = IndexModifier::factory([
            'type' => 'primary',
            'columns' => $columns,
            'name' => $name,
        ]);
        $this->assertSame($expected, $indexModifier->createIndexMigrationDownMethod());
    }

    /**
     * @return array<string, array<string, mixed>>
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
