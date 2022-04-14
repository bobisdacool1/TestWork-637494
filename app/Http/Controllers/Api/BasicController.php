<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\ChannelSearchRequest;
use App\Http\Requests\ChannelsGetRequset;
use App\Http\Requests\ChannelStoreRequest;
use App\Http\Requests\ChannelUpdateRequest;

abstract class BasicController extends ApiController
{
    protected function newRepository()
    {
        abort(400, 'Non implemented');
    }

    public function index(ChannelsGetRequset $request)
    {
        $request->validated();

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

    public function search(ChannelSearchRequest $request)
    {
        $request->validated();

        $sort['field'] = $request->input('sort_by', 'created_at');
        $sort['order'] = $request->input('sort_order', 'asc');

        $searchField = $request->input('search', []);
        $searchPivotField = $request->input('search_pivot', []);

        $channels = $this->repository->search($searchField, $searchPivotField, $sort);

        return response()->json($channels);

    }

    public function store(ChannelStoreRequest $request)
    {
        $request->validated();

        $channelFields['name'] = $request->input('name');

        $channel = $this->repository->save($channelFields);

        return response()->json($channel);
    }

    public function update(ChannelUpdateRequest $request, int $channelId)
    {
        $attributes['name'] = $request->name;

        $channel = $this->repository->update($channelId, $attributes);

        return response()->json($channel);
    }

    public function destroy(int $channelId)
    {
        $deleted = $this->repository->destroy($channelId);

        return response()->json(['deleted' => $deleted]);
    }
}
