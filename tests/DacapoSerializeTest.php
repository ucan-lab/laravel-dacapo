<?php

namespace UcanLab\LaravelDacapo\Test;

use Illuminate\Support\Facades\DB;
use UcanLab\LaravelDacapo\Migrations\Connections;
use UcanLab\LaravelDacapo\Migrations\DacapoSerializer;
use UcanLab\LaravelDacapo\Storage\MigrationsStorage;
use UcanLab\LaravelDacapo\Storage\SchemasStorage;

class DacapoSerializeTest extends TestCase
{
    public function testResolve(): void
    {
        $this->createApplication();

        DB::connection('testing')->statement("
            create table users(
                id integer primary key autoincrement,
                email text not null unique,
                created_at datetime,
                updated_at datetime
            );
            create table profiles(
                id integer primary key autoincrement,
                user_id integer unsigned not null,
                name text not null default 'no name',
                name body not null,
                created_at datetime,
                updated_at datetime,
                foreign key (user_id) references users(usersid)
            );
        ");

        /** @var Connections $connections */
        $connections = $this->app->make(Connections::class);
        $connections->add('testing');

        (new DacapoSerializer(new SchemasStorage(), new MigrationsStorage(), $connections))->run();
    }
}
