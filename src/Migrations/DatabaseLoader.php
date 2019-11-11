<?php

namespace UcanLab\LaravelDacapo\Migrations;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Database\ConnectionInterface;

class DatabaseLoader
{
    /**
     * @var \Illuminate\Database\ConnectionInterface|\Illuminate\Database\Connection
     */
    private $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws
     */
    public function run(): void
    {
        $doctrine = $this->getDoctrineSchemaManager();

        dump($doctrine->listTables());

        foreach ($doctrine->listTables() as $table) {
            $name = $table->getName();
            $comment = $table->getComment();
            $columns = $table->getColumns();
            $foreignKeys = $table->getForeignKeys();
            $indexes = $table->getIndexes();
            $options = $table->getOptions();
            $primaryKeyIndex = $table->getPrimaryKey();

            if ($table->hasPrimaryKey()) {
                $primaryKeyColumns = $table->getPrimaryKeyColumns();
                dump($name, $comment, $columns, $foreignKeys, $indexes, $options, $primaryKeyIndex, $primaryKeyColumns);
            }
        }
    }

    /**
     * @return \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    private function getDoctrineSchemaManager(): AbstractSchemaManager
    {
        if (!class_exists(\Doctrine\DBAL\Schema\AbstractSchemaManager::class)) {
            // @codeCoverageIgnoreStart
            throw new \RuntimeException('You must install doctrine/dbal for this feature.');
            // @codeCoverageIgnoreEnd
        }

        return $this->connection->getDoctrineSchemaManager();
    }
}
