<?php


namespace App\Repositories;


use App\Models\Channel;

class ChannelRepository extends BasicRepository
{
    public function search(array $searchFields = [], array $searchPivotFields = [], array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return $this->getModelWithRelations()
                ->where(function ($query) use ($searchFields) {
                    foreach ($searchFields as $searchKey => $searchValue) {
                        $query->where($searchKey, 'LIKE', "%$searchValue%");
                    }
                })
                ->whereHas('subscribers', function ($query) use ($searchPivotFields) {
                    foreach ($searchPivotFields as $searchKey => $searchValue) {
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

    protected function getModelWithRelations()
    {
        return Channel::with('subscribers');
    }

    protected function getModel()
    {
        return Channel::class;
    }
}
