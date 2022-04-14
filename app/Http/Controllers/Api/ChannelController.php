<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ChannelRepository;

class ChannelController extends BasicController
{
    protected function newRepository()
    {
        return new ChannelRepository();
    }
}
