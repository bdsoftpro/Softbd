<?php

namespace SBD\Softbd\Database\Types\Sqlite;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SBD\Softbd\Database\Types\Type;

class RealType extends Type
{
    const NAME = 'real';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
