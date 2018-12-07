<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 6:36 PM
 */

namespace App\Sdc\Responses;


abstract class ErrorResponse
{
    public $status;
    public $message;
    public $code;

}
