<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 7:32 PM
 */

namespace App\Sdc\Utilities;


class ErrorServerResponse extends ErrorResponse
{
    public function __construct()
    {
        $this->status = Constants::CODE_SERVER_ERROR;
        $this->message = Constants::RESPONSE_SERVER_ERROR;
        $this->code = Constants::CODE_SERVER_ERROR;
    }

}
