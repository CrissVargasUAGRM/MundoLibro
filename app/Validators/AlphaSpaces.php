<?php

namespace App\Validators;

class AlphaSpaces{
    function validate($atribbute,$value,$params,$validator){
        return preg_match('/^[\pL\.\s]+$/u',$value);
    }
}