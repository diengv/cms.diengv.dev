<?php

namespace App\Http\Requests;

use App\Models\CmsTerm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCmsTermRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_term_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'slug' => [
                'string',
                'nullable',
            ],
            'term_group' => [
                'string',
                'nullable',
            ],
        ];
    }
}
