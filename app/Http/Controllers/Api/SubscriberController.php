<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\SubscriberStoreRequest;
use App\Repositories\SubscriberRepository;

class SubscriberController extends BasicController
{
    protected function newRepository()
    {
        return new SubscriberRepository();
    }

    public function store(SubscriberStoreRequest $request)
    {
        $channel = $this->repository->save($request->validated());

        return response()->json($channel);
    }

    public function update(SubscriberStoreRequest $request, int $id)
    {
        $channel = $this->repository->update($id, $request->validated());

        return response()->json($channel);
    }
}
