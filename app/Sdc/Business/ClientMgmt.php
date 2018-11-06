<?php

namespace App\Sdc\Business;

use App\Sdc\Repositories\ClientRepositoryInterface;

class ClientMgmt {

    protected $clientDao;
    protected $class = "ClientMgmt";

    public function __construct(ClientRepositoryInterface $clientDao){
        $this->clientDao = $clientDao;
    }
}
