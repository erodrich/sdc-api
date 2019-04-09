<?php
/**
 * Created by PhpStorm.
 * User: erodrich
 * Date: 12/7/18
 * Time: 10:51 PM
 */

namespace App\Sdc\Business;

use App\Sdc\Repositories\InteractionRepositoryInterface;

class InteractionBusiness
{

    protected $class = "InteractionBusiness";
    protected $interactionDao;

    public function __construct(InteractionRepositoryInterface $interactionDao)
    {
        $this->interactionDao = $interactionDao;
    }

    public function retrieveAll()
    {
        return $this->interactionDao->retrieveAll();
    }

    public function save(array $data)
    {
        return $this->interactionDao->save($data);
    }

    public function retrieveById(int $ad)
    {
        return $this->interactionDao->retrieveById($ad);
    }

    public function update(array $data, $id)
    {
        return $this->interactionDao->update($data, $id);
    }

    public function delete($id)
    {
        return $this->interactionDao->delete($id);
    }

    public function retrieveByParams(int $client_id, array $data){
        return $this->interactionDao->retrieveByParams($client_id, $data);
    }

    public function retrieveByClient(int $client_id){
        return $this->interactionDao->retrieveByClient($client_id);
    }


}
