<?php

namespace App\Sdc\Repositories;

interface BaseRepositoryInterface {

    public function retrieveAll();
    public function retrieveById(int $id);
    public function save(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
}