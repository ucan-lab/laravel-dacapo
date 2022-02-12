<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\ForeignKey;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Test\TestCase;

final class ForeignKeyTest extends TestCase
{
    /**
     * @param string $expectedUp
     * @param string $expectedDown
     * @param string|array<int, string> $columns
     * @param string|array<int, string> $references
     * @param string $on
     * @param string|null $name
     * @param string|null $onUpdateAction
     * @param string|null $onDeleteAction
     * @dataProvider dataResolve
     */
    public function testResolve(
        string $expectedUp,
        string $expectedDown,
        string|array $columns,
        string|array $references,
        string $on,
        ?string $name,
        ?string $onUpdateAction,
        ?string $onDeleteAction
    ): void {
        $foreignKey = ForeignKey::factory([
            'columns' => $columns,
            'references' => $references,
            'table' => $on,
            'name' => $name,
            'onUpdateAction' => $onUpdateAction,
            'onDeleteAction' => $onDeleteAction,
        ]);

        $this->assertSame($expectedUp, $foreignKey->createForeignKeyMigrationUpMethod());
        $this->assertSame($expectedDown, $foreignKey->createForeignKeyMigrationDownMethod());
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function dataResolve(): array
    {
        return [
            'columns:one' => [
                'expectedUp' => '$table' . "->foreign('user_id')->references('id')->on('users');",
                'expectedDown' => '$table' . "->dropForeign(['user_id']);",
                'columns' => 'user_id',
                'references' => 'id',
                'table' => 'users',
                'name' => null,
                'onUpdateAction' => null,
                'onDeleteAction' => null,
            ],
            'columns:two' => [
                'expectedUp' => '$table' . "->foreign(['product_category', 'product_id'])->references(['category', 'id'])->on('product');",
                'expectedDown' => '$table' . "->dropForeign(['product_category', 'product_id']);",
                'columns' => ['product_category', 'product_id'],
                'references' => ['category', 'id'],
                'table' => 'product',
                'name' => null,
                'onUpdateAction' => null,
                'onDeleteAction' => null,
            ],
            'name:alias' => [
                'expectedUp' => '$table' . "->foreign('user_id', 'sample_foreign_key')->references('id')->on('users');",
                'expectedDown' => '$table' . "->dropForeign('sample_foreign_key');",
                'columns' => 'user_id',
                'references' => 'id',
                'table' => 'users',
                'name' => 'sample_foreign_key',
                'onUpdateAction' => null,
                'onDeleteAction' => null,
            ],
            'action:cascade' => [
                'expectedUp' => '$table' . "->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');",
                'expectedDown' => '$table' . "->dropForeign(['user_id']);",
                'columns' => 'user_id',
                'references' => 'id',
                'table' => 'users',
                'name' => null,
                'onUpdateAction' => 'cascade',
                'onDeleteAction' => 'cascade',
            ],
        ];
    }
}
