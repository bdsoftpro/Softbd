<?php

namespace SBD\Softbd\FormFields;

class TimestampHandler extends AbstractHandler
{
    protected $codename = 'timestamp';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('softbd::formfields.timestamp', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
