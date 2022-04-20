<?php

namespace App\Http\Requests\Basic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IndexRequest extends FormRequest
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
            'count' => 'int',
            'sort_order' => 'in:asc,desc',
            'sort_by' => 'string'
        ];
    }
}
