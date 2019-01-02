<?php

namespace App\Sdc\Repositories;
use App\Sdc\Repositories\BaseRepositoryInterface;

interface InteractionRepositoryInterface extends BaseRepositoryInterface{


    public function retrieveByParams(int $client_id, array $data);
}
