<?php


namespace App\Repositories;


use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\IBasicRepository;

abstract class BasicRepository extends Repository implements IBasicRepository
{
    public function getAll(int $quantity = 50, array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return $this->getModelWithRelations()
                ->take($quantity)
                ->orderBy($sort['field'], $sort['order'])
                ->get()
                ->toArray();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function getById(int $channelId)
    {
        try {
            return $this->getModelWithRelations()->where('id', $channelId)->first();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function search(array $searchFields = [], array $searchPivotFields = [], array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return $this->getModelWithRelations()
                ->where(function ($query) use ($searchFields) {
                    foreach ($searchFields as $searchKey => $searchValue) {
                        $query->where($searchKey, 'LIKE', "%$searchValue%");
                    }
                })
                ->take(10)
                ->orderBy($sort['field'], $sort['order'])
                ->get();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function destroy(int $channelId)
    {
        try {
            $channel = $this->getModel()::where('id', $channelId)->first();

            if ($channel == null)
                abort(400);

            return $channel->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function update(int $channelId, array $fields)
    {
        try {
            $channel = $this->getModelWithRelations()->where('id', $channelId)->first();

            if ($channel == null)
                abort(400);

            $channel->fill($fields);
            $channel->save();

            return $channel;
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function save(array $fields)
    {
        try {
            $channel = new ($this->getModel())();
            $channel->fill($fields);
            $channel->save();

            return $channel;
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }


    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */

    protected function getModelWithRelations()
    {
        abort(400, 'Non implemented');
    }

    /**
     * @return Model
     */
    protected function getModel()
    {
        abort(400, 'Non implemented repository');
    }
}
