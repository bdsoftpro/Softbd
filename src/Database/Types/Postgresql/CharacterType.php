<?php

namespace SBD\Softbd\Database\Types\Postgresql;

use SBD\Softbd\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
