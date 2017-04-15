<?php

namespace SBD\Softbd\Database\Types\Postgresql;

use SBD\Softbd\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
