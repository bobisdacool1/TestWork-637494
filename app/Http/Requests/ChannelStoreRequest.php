<?php

namespace App\Http\Requests;

use App\Http\Requests\Basic\StoreRequest;
use Illuminate\Support\Facades\Auth;

class ChannelStoreRequest extends StoreRequest
{
    public function authorize()
    {
        if (!Auth::check()) {
            abort(403);
        }

        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:10'
        ];
    }
}
