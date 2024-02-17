<?php

namespace App\Http\Requests;

use App\Models\CmsTermRelationship;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCmsTermRelationshipRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_term_relationship_create');
    }

    public function rules()
    {
        return [
            'object' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'term_taxonomy_id' => [
                'required',
                'integer',
            ],
            'term_order' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
