<?php /** @noinspection PhpInconsistentReturnPointsInspection */


namespace App\Repositories;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\IBasicRepository;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BasicRepository extends Repository implements IBasicRepository
{
    public function getAll(int $quantity = 50, array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return $this->getResource()::collection(
                $this->getModelWithRelations()
                    ->take($quantity)
                    ->orderBy($sort['field'], $sort['order'])
                    ->get()
            );
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function getById(int $id)
    {
        try {
            return $this->getResource()::collection(
                $this->getModelWithRelations()->where('id', $id)->first()
            );
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function search(array $searchFields = [], array $searchPivotFields = [], array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            // maybe that's too heavy, idk
            return $this->getResource()::collection(
                $this->getModelWithRelations()
                    ->where(function ($query) use ($searchFields) {
                        foreach ($searchFields as $searchKey => $searchValue) {
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

    public function destroy(int $channelId)
    {
        try {
            $model = $this->getModel()::where('id', $channelId)->first();

            if ($model == null)
                abort(400);

            return $model->delete();
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function update(int $channelId, array $fields)
    {
        try {
            $model = $this->getModelWithRelations()->where('id', $channelId)->first();

            if ($model == null)
                abort(400);

            $model->fill($fields);
            $model->save();

            return $this->getResource()::collection($model);
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    public function save(array $fields)
    {
        try {
            $model = new ($this->getModel())();
            $model->fill($fields);
            $model->save();

            return $this->getResource()::collection($model);
        } catch (Exception $e) {
            abort(400, $e->getMessage());
        }
    }


    /**
     * @return Builder
     */

    abstract protected function getModelWithRelations();

    /**
     * @return Model
     */
    abstract protected function getModel();

    /**
     * @return JsonResource
     */
    abstract protected function getResource();
}
