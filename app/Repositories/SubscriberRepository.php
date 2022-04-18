<?php /** @noinspection PhpInconsistentReturnPointsInspection */


namespace App\Repositories;


use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Exception;

class SubscriberRepository extends BasicRepository
{
    public function search(array $searchFields = [], array $searchPivotFields = [], array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return SubscriberResource::collection(
                $this->getModelWithRelations()
                    ->where(function ($query) use ($searchFields) {
                        foreach ($searchFields as $searchKey => $searchValue) {
                            $query->where($searchKey, 'LIKE', "%$searchValue%");
                        }
                    })
                    ->whereHas('channels', function ($query) use ($searchPivotFields) {
                        foreach ($searchPivotFields as $searchKey => $searchValue) {
                            $query->where($searchKey, 'LIKE', "%$searchValue%");
                        }
                    })
                    ->take(10)
                    ->orderBy($sort['field'], $sort['order'])
                    ->get()
            );
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    protected function getModelWithRelations()
    {
        return Subscriber::with('channels');
    }

    protected function getModel()
    {
        return Subscriber::class;
    }

    protected function getResource()
    {
        return SubscriberResource::class;
    }
}
