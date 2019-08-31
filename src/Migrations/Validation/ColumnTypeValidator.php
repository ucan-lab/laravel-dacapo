<?php

namespace UcanLab\LaravelDacapo\Migrations\Validation;

use Illuminate\Validation\Validator;

class ColumnTypeValidator extends Validator
{
    private $available = [
        'bigIncrements',
        'bigInteger',
        'binary',
        'boolean',
        'char',
        'date',
        'dateTime',
        'dateTimeTz',
        'decimal',
        'double',
        'enum',
        'float',
        'geometry',
        'geometryCollection',
        'increments',
        'integer',
        'ipAddress',
        'json',
        'jsonb',
        'lineString',
        'longText',
        'macAddress',
        'mediumIncrements',
        'mediumInteger',
        'mediumText',
        'morphs',
        'uuidMorphs',
        'multiLineString',
        'multiPoint',
        'multiPolygon',
        'nullableMorphs',
        'nullableUuidMorphs',
        'nullableTimestamps',
        'point',
        'polygon',
        'rememberToken',
        'set',
        'smallIncrements',
        'smallInteger',
        'softDeletes',
        'softDeletesTz',
        'string',
        'text',
        'time',
        'timeTz',
        'timestamp',
        'timestampTz',
        'timestamps',
        'timestampsTz',
        'tinyIncrements',
        'tinyInteger',
        'unsignedBigInteger',
        'unsignedDecimal',
        'unsignedInteger',
        'unsignedMediumInteger',
        'unsignedSmallInteger',
        'unsignedTinyInteger',
        'uuid',
        'year',
    ];

    /**
     * 使用できるカラムタイプのバリデーション
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateColumnType(string $attribute, $value, $parameters)
    {
        if (mb_strlen($value) > 100) {
            return false;
        }

        if (preg_match('/[^ぁ-んー]/u', $value) !== 0) {
            return false;
        }

        return true;
    }
}
