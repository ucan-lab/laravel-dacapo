<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Factory;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BigIncrementsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BigIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BinaryType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\BooleanType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\CharType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ColumnType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DateTimeType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DateTimeTzType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DateType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DecimalType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\DoubleType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\EnumType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\FloatType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\ForeignIdType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\GeometryCollectionType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\GeometryType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IdType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IncrementsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\IpAddressType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\JsonbType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\JsonType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\LineStringType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\LongTextType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MacAddressType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumIncrementsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MediumTextType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MorphsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiLineStringType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiPointType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\MultiPolygonType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableMorphsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableTimestampsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\NullableUuidMorphsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PointType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\PolygonType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\RememberTokenType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SetType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SmallIncrementsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SmallIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SoftDeletesType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\SoftDeletesTzType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\StringType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TextType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampsTzType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimestampTzType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimeType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TimeTzType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TinyIncrementsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\TinyIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedBigIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedDecimalType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedMediumIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedSmallIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UnsignedTinyIntegerType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UuidMorphsType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\UuidType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType\YearType;

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
