<?php

namespace SBD\Softbd\Database\Types\Common;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SBD\Softbd\Database\Types\Type;

class JsonType extends Type
{
    const NAME = 'json';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'json';
    }
}
