<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Storage;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

interface DatabaseSchemasStorage
{
    public function getSchemaList(): SchemaList;
}
