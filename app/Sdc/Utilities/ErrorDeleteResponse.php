<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/4/18
 * Time: 7:43 PM
 */

namespace App\Sdc\Utilities;


class ErrorDeleteResponse extends ErrorResponse
{
    public function __construct()
    {
        $this->status = Constants::CODE_DELETE;
        $this->message = Constants::RESPONSE_DELETE;
        $this->code = Constants::CODE_DELETE;
    }
}
