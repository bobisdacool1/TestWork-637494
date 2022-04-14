<?php

namespace App\Http\Controllers\Api;


use App\Repositories\SubscriberRepository;

class SubscriberController extends BasicController
{
    protected function newRepository()
    {
        return new SubscriberRepository();
    }
}
