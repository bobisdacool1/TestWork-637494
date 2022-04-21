<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Basic\IndexRequest;
use App\Http\Requests\Basic\SearchRequest;

abstract class BasicController extends Controller
{
    abstract protected function newRepository();

    public function index(IndexRequest $request)
    {
        $sort['field'] = $request->input('sort_by', 'created_at');
        $sort['order'] = $request->input('sort_order', 'asc');
        $count = $request->input('count', 50);

        $models = $this->repository->getAll($count, $sort);

        return response()->json($models);
    }

    public function show(int $id)
    {
        $model = $this->repository->getById($id);

        return response()->json($model);
    }

    public function search(SearchRequest $request)
    {
        $sort['field'] = $request->input('sort_by', 'created_at');
        $sort['order'] = $request->input('sort_order', 'asc');

        $searchField = $request->input('search', []);
        $searchPivotField = $request->input('search_pivot', []);

        $models = $this->repository->search($searchField, $searchPivotField, $sort);

        return response()->json($models);

    }

    public function destroy(int $id)
    {
        $deleted = $this->repository->destroy($id);

        return response()->json(['deleted' => $deleted]);
    }
}
