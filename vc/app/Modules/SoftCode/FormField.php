<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 2/6/18
 * Time: 10:42 PM
 */

namespace App\Modules\SoftCode;

class FormField
{

    function __construct()
    {
    }

    public function attendToEventVia(){
        return [
            0   => 'Via DLT',
            1   => 'Through Internet'
        ];
    }
}