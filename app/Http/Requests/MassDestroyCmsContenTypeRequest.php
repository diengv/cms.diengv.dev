<?php

namespace App\Http\Requests;

use App\Models\CmsContenType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCmsContenTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cms_conten_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cms_conten_types,id',
        ];
    }
}
