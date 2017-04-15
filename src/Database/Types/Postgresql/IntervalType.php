<?php

namespace SBD\Softbd\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SBD\Softbd\Database\Types\Type;

class IntervalType extends Type
{
    const NAME = 'interval';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'interval';
    }
}
