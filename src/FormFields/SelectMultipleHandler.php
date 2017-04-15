<?php

namespace SBD\Softbd\FormFields;

class SelectMultipleHandler extends AbstractHandler
{
    protected $codename = 'select_multiple';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('softbd::formfields.select_multiple', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
