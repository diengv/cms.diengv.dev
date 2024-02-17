<?php

namespace App\Http\Requests;

use App\Models\CmsTermTaxonomy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCmsTermTaxonomyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cms_term_taxonomy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cms_term_taxonomies,id',
        ];
    }
}
