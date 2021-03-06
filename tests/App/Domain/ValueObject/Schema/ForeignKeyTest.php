<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\Domain\ValueObject\Schema;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey\Reference;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey\ReferenceAction;
use UcanLab\LaravelDacapo\Test\TestCase;

class ForeignKeyTest extends TestCase
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
        $reference = new Reference($columns, $references, $on, $name);
        $referenceAction = new ReferenceAction($onUpdate, $onDelete);
        $foreignKey = new ForeignKey($reference, $referenceAction);

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
