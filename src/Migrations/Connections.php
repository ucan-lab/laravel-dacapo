<?php

namespace UcanLab\LaravelDacapo\Migrations;

use ArrayIterator;
use Illuminate\Database\DatabaseManager;
use IteratorAggregate;

class Connections implements IteratorAggregate
{
    private $db;
    private $connections = [];

    /**
     * @param \Illuminate\Database\DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $connection
     * @return self
     */
    public function add(?string $connection): self
    {
        $this->connections[$connection ?? $this->db->getDefaultConnection()] = $this->db->connection($connection);

        return $this;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->connections);
    }
}
