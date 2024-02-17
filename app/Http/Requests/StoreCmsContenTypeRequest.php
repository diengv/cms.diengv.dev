<?php

namespace App\Http\Requests;

use App\Models\CmsContenType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCmsContenTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_conten_type_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
