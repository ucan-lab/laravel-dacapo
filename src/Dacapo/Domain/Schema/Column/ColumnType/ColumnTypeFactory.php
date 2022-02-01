<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\Column\ColumnType\InvalidArgumentException;

final class ColumnTypeFactory
{
    private const MAPPING_CLASS = [
        'bigIncrements' => BigIncrementsType::class,
        'bigInteger' => BigIntegerType::class,
        'binary' => BinaryType::class,
        'boolean' => BooleanType::class,
        'char' => CharType::class,
        'dateTime' => DateTimeType::class,
        'dateTimeTz' => DateTimeTzType::class,
        'date' => DateType::class,
        'decimal' => DecimalType::class,
        'double' => DoubleType::class,
        'enum' => EnumType::class,
        'float' => FloatType::class,
        'foreignId' => ForeignIdType::class,
        'geometryCollection' => GeometryCollectionType::class,
        'geometry' => GeometryType::class,
        'id' => IdType::class,
        'increments' => IncrementsType::class,
        'integer' => IntegerType::class,
        'ipAddress' => IpAddressType::class,
        'jsonb' => JsonbType::class,
        'json' => JsonType::class,
        'lineString' => LineStringType::class,
        'longText' => LongTextType::class,
        'macAddress' => MacAddressType::class,
        'mediumIncrements' => MediumIncrementsType::class,
        'mediumInteger' => MediumIntegerType::class,
        'mediumText' => MediumTextType::class,
        'morphs' => MorphsType::class,
        'multiLineString' => MultiLineStringType::class,
        'multiPoint' => MultiPointType::class,
        'multiPolygon' => MultiPolygonType::class,
        'nullableMorphs' => NullableMorphsType::class,
        'nullableTimestamps' => NullableTimestampsType::class,
        'nullableUuidMorphs' => NullableUuidMorphsType::class,
        'point' => PointType::class,
        'polygon' => PolygonType::class,
        'rememberToken' => RememberTokenType::class,
        'set' => SetType::class,
        'smallIncrements' => SmallIncrementsType::class,
        'smallInteger' => SmallIntegerType::class,
        'softDeletes' => SoftDeletesType::class,
        'softDeletesTz' => SoftDeletesTzType::class,
        'string' => StringType::class,
        'text' => TextType::class,
        'timestamps' => TimestampsType::class,
        'timestampsTz' => TimestampsTzType::class,
        'timestamp' => TimestampType::class,
        'timestampTz' => TimestampTzType::class,
        'time' => TimeType::class,
        'timeTz' => TimeTzType::class,
        'tinyIncrements' => TinyIncrementsType::class,
        'tinyInteger' => TinyIntegerType::class,
        'unsignedBigInteger' => UnsignedBigIntegerType::class,
        'unsignedDecimal' => UnsignedDecimalType::class,
        'unsignedInteger' => UnsignedIntegerType::class,
        'unsignedMediumInteger' => UnsignedMediumIntegerType::class,
        'unsignedSmallInteger' => UnsignedSmallIntegerType::class,
        'unsignedTinyInteger' => UnsignedTinyIntegerType::class,
        'uuidMorphs' => UuidMorphsType::class,
        'uuid' => UuidType::class,
        'year' => YearType::class,
    ];

    /**
     * @param string $name
     * @param null $args
     * @return ColumnType
     */
    public static function factory(string $name, $args = null): ColumnType
    {
        if ($class = self::MAPPING_CLASS[$name] ?? null) {
            return new $class($args);
        }

        throw new InvalidArgumentException(sprintf('%s column type does not exist', $name));
    }
}
