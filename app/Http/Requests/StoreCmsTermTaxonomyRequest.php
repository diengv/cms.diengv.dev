<?php

namespace App\Http\Requests;

use App\Models\CmsTermTaxonomy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCmsTermTaxonomyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_term_taxonomy_create');
    }

    public function rules()
    {
        return [
            'term_id' => [
                'required',
                'integer',
            ],
            'taxonomy_id' => [
                'required',
                'integer',
            ],
            'count' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
