<?php /** @noinspection PhpInconsistentReturnPointsInspection */


namespace App\Repositories;


use App\Repositories\Interfaces\IBasicRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BasicRepository extends Repository implements IBasicRepository
{
    public function getAll(int $quantity = 50, array $sort = ['field' => 'created_at', 'order' => 'asc'])
    {
        try {
            return $this->newResourceCollection(
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
            return $this->newResource(
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
            return $this->newResourceCollection(
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

    public function destroy(int $id)
    {
        try {
            $model = $this->getModel()::where('id', $id)->first();

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

            return $this->newResource($model);
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

            return $this->newResource($model);
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
     * @param $data
     * @return JsonResource
     */
    abstract protected function newResourceCollection($data);

    /**
     * @return JsonResource
     */
    abstract protected function newResource($object);
}
