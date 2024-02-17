<?php

namespace App\Http\Requests;

use App\Models\CmsContentMetum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCmsContentMetumRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cms_content_metum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cms_content_meta,id',
        ];
    }
}
