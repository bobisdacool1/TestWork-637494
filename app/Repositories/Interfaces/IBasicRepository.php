<?php


namespace App\Repositories\Interfaces;


interface IBasicRepository
{
    public function getAll(int $quantity = 50, array $sort = ['order' => 'asc', 'field' => 'created_at']);
    public function getById(int $id);
    public function search(array $searchFields = [], array $searchPivotFields = [], array $sort = ['order' => 'asc', 'field' => 'created_at']);
    public function destroy(int $channelId);
    public function update(int $channelId, array $fields);
    public function save(array $fields);
}
