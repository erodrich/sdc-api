<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 7:32 PM
 */

namespace App\Sdc\Utilities;


class ErrorNotFoundResponse extends ErrorResponse
{
    public function __construct()
    {
        $this->status = Constants::CODE_BAD_REQUEST;
        $this->message = Constants::RESPONSE_NOT_FOUND;
        $this->code = Constants::CODE_BAD_REQUEST;
    }

}
