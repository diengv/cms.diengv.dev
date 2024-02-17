<?php

namespace App\Http\Requests;

use App\Models\CmsContentMetum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCmsContentMetumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_content_metum_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'type' => [
                'string',
                'required',
            ],
            'post_id' => [
                'required',
                'integer',
            ],
            'assets.*' => [
                'integer',
            ],
            'assets' => [
                'array',
            ],
        ];
    }
}
