<?php

namespace SBD\Softbd\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SBD\Softbd\Database\Types\Type;

class PointType extends Type
{
    const NAME = 'point';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'point';
    }
}
