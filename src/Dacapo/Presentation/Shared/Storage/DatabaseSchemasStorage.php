<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

interface DatabaseSchemasStorage
{
    /**
     * @return SchemaList
     */
    public function getSchemaList(): SchemaList;
}
