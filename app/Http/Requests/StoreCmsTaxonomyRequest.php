<?php

namespace App\Http\Requests;

use App\Models\CmsTaxonomy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCmsTaxonomyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_taxonomy_create');
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
            'hierarchical' => [
                'required',
            ],
        ];
    }
}
