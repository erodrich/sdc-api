<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 6:41 PM
 */

namespace App\Sdc\Utilities;


class ErrorValidationResponse extends ErrorResponse
{

    public function __construct()
    {
        $this->status = Constants::CODE_BAD_REQUEST;
        $this->message = Constants::RESPONSE_BAD_REQUEST;
        $this->code = Constants::CODE_BAD_REQUEST;
    }
}
