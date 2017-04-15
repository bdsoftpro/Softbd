<?php

namespace SBD\Softbd\Database\Types\Postgresql;

use SBD\Softbd\Database\Types\Common\DoubleType;

class DoublePrecisionType extends DoubleType
{
    const NAME = 'double precision';
    const DBTYPE = 'float8';
}
