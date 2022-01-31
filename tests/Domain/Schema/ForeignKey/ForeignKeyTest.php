<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Domain\Schema\ForeignKey;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey\ReferenceAction;
use UcanLab\LaravelDacapo\Test\TestCase;

final class ForeignKeyTest extends TestCase
{
    /**
     * @param string $expectedUp
     * @param string $expectedDown
     * @param $columns
     * @param $references
     * @param string $on
     * @param string|null $name
     * @param string|null $onUpdate
     * @param string|null $onDelete
     * @dataProvider dataResolve
     */
    public function testResolve(string $expectedUp, string $expectedDown, $columns, $references, string $on, ?string $name, ?string $onUpdate, ?string $onDelete): void
    {
        $foreignKey = ForeignKey::factory([
            'columns' => $columns,
            'references' => $references,
            'on' => $on,
            'name' => $name,
            'onUpdate' => $onUpdate,
            'onDelete' => $onDelete,
        ]);

        $this->assertSame($expectedUp, $foreignKey->createForeignKeyMigrationUpMethod());
        $this->assertSame($expectedDown, $foreignKey->createForeignKeyMigrationDownMethod());
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        return [
            'columns:one' => [
                'expectedUp' => '$table' . "->foreign('user_id')->references('id')->on('users');",
                'expectedDown' => '$table' . "->dropForeign(['user_id']);",
                'columns' => 'user_id',
                'references' => 'id',
                'on' => 'users',
                'name' => null,
                'onUpdate' => null,
                'onDelete' => null,
            ],
            'columns:two' => [
                'expectedUp' => '$table' . "->foreign(['product_category', 'product_id'])->references(['category', 'id'])->on('product');",
                'expectedDown' => '$table' . "->dropForeign(['product_category', 'product_id']);",
                'columns' => ['product_category', 'product_id'],
                'references' => ['category', 'id'],
                'on' => 'product',
                'name' => null,
                'onUpdate' => null,
                'onDelete' => null,
            ],
            'name:alias' => [
                'expectedUp' => '$table' . "->foreign('user_id', 'sample_foreign_key')->references('id')->on('users');",
                'expectedDown' => '$table' . "->dropForeign('sample_foreign_key');",
                'columns' => 'user_id',
                'references' => 'id',
                'on' => 'users',
                'name' => 'sample_foreign_key',
                'onUpdate' => null,
                'onDelete' => null,
            ],
            'action:cascade' => [
                'expectedUp' => '$table' . "->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');",
                'expectedDown' => '$table' . "->dropForeign(['user_id']);",
                'columns' => 'user_id',
                'references' => 'id',
                'on' => 'users',
                'name' => null,
                'onUpdate' => 'cascade',
                'onDelete' => 'cascade',
            ],
        ];
    }
}
