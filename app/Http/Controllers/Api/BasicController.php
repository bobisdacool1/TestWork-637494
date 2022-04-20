<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\Basic\IndexRequest;
use App\Http\Requests\Basic\SearchRequest;

abstract class BasicController extends ApiController
{
    protected function newRepository()
    {
        abort(400, 'Non implemented');
    }

    public function index(IndexRequest $request)
    {
        $sort['field'] = $request->input('sort_by', 'created_at');
        $sort['order'] = $request->input('sort_order', 'asc');
        $count = $request->input('count', 50);

        $channels = $this->repository->getAll($count, $sort);

        return response()->json($channels);
    }

    public function show(int $channelId)
    {
        $channel = $this->repository->getById($channelId);

        return response()->json($channel);
    }

    public function search(SearchRequest $request)
    {
        $sort['field'] = $request->input('sort_by', 'created_at');
        $sort['order'] = $request->input('sort_order', 'asc');

        $searchField = $request->input('search', []);
        $searchPivotField = $request->input('search_pivot', []);

        $channels = $this->repository->search($searchField, $searchPivotField, $sort);

        return response()->json($channels);

    }

    public function destroy(int $channelId)
    {
        $deleted = $this->repository->destroy($channelId);

        return response()->json(['deleted' => $deleted]);
    }
}
