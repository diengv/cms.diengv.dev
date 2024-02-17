<?php

namespace App\Http\Requests;

use App\Models\CmsTermRelationship;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCmsTermRelationshipRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cms_term_relationship_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cms_term_relationships,id',
        ];
    }
}
