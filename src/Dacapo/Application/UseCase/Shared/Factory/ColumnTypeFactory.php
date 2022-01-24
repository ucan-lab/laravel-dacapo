<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

final class ColumnTypeFactory
{
    private const MAPPING_CLASS = [
        'bigIncrements' => ColumnType\BigIncrementsType::class,
        'bigInteger' => ColumnType\BigIntegerType::class,
        'binary' => ColumnType\BinaryType::class,
        'boolean' => ColumnType\BooleanType::class,
        'char' => ColumnType\CharType::class,
        'dateTime' => ColumnType\DateTimeType::class,
        'dateTimeTz' => ColumnType\DateTimeTzType::class,
        'date' => ColumnType\DateType::class,
        'decimal' => ColumnType\DecimalType::class,
        'double' => ColumnType\DoubleType::class,
        'enum' => ColumnType\EnumType::class,
        'float' => ColumnType\FloatType::class,
        'foreignId' => ColumnType\ForeignIdType::class,
        'geometryCollection' => ColumnType\GeometryCollectionType::class,
        'geometry' => ColumnType\GeometryType::class,
        'id' => ColumnType\IdType::class,
        'increments' => ColumnType\IncrementsType::class,
        'integer' => ColumnType\IntegerType::class,
        'ipAddress' => ColumnType\IpAddressType::class,
        'jsonb' => ColumnType\JsonbType::class,
        'json' => ColumnType\JsonType::class,
        'lineString' => ColumnType\LineStringType::class,
        'longText' => ColumnType\LongTextType::class,
        'macAddress' => ColumnType\MacAddressType::class,
        'mediumIncrements' => ColumnType\MediumIncrementsType::class,
        'mediumInteger' => ColumnType\MediumIntegerType::class,
        'mediumText' => ColumnType\MediumTextType::class,
        'morphs' => ColumnType\MorphsType::class,
        'multiLineString' => ColumnType\MultiLineStringType::class,
        'multiPoint' => ColumnType\MultiPointType::class,
        'multiPolygon' => ColumnType\MultiPolygonType::class,
        'nullableMorphs' => ColumnType\NullableMorphsType::class,
        'nullableTimestamps' => ColumnType\NullableTimestampsType::class,
        'nullableUuidMorphs' => ColumnType\NullableUuidMorphsType::class,
        'point' => ColumnType\PointType::class,
        'polygon' => ColumnType\PolygonType::class,
        'rememberToken' => ColumnType\RememberTokenType::class,
        'set' => ColumnType\SetType::class,
        'smallIncrements' => ColumnType\SmallIncrementsType::class,
        'smallInteger' => ColumnType\SmallIntegerType::class,
        'softDeletes' => ColumnType\SoftDeletesType::class,
        'softDeletesTz' => ColumnType\SoftDeletesTzType::class,
        'string' => ColumnType\StringType::class,
        'text' => ColumnType\TextType::class,
        'timestamps' => ColumnType\TimestampsType::class,
        'timestampsTz' => ColumnType\TimestampsTzType::class,
        'timestamp' => ColumnType\TimestampType::class,
        'timestampTz' => ColumnType\TimestampTzType::class,
        'time' => ColumnType\TimeType::class,
        'timeTz' => ColumnType\TimeTzType::class,
        'tinyIncrements' => ColumnType\TinyIncrementsType::class,
        'tinyInteger' => ColumnType\TinyIntegerType::class,
        'unsignedBigInteger' => ColumnType\UnsignedBigIntegerType::class,
        'unsignedDecimal' => ColumnType\UnsignedDecimalType::class,
        'unsignedInteger' => ColumnType\UnsignedIntegerType::class,
        'unsignedMediumInteger' => ColumnType\UnsignedMediumIntegerType::class,
        'unsignedSmallInteger' => ColumnType\UnsignedSmallIntegerType::class,
        'unsignedTinyInteger' => ColumnType\UnsignedTinyIntegerType::class,
        'uuidMorphs' => ColumnType\UuidMorphsType::class,
        'uuid' => ColumnType\UuidType::class,
        'year' => ColumnType\YearType::class,
    ];

    /**
     * @param string $name
     * @param null $args
     * @return ColumnType
     */
    public function factory(string $name, $args = null): ColumnType
    {
        if ($class = self::MAPPING_CLASS[$name] ?? null) {
            return new $class($args);
        }

        throw new InvalidArgumentException(sprintf('%s column type does not exist', $name));
    }
}
