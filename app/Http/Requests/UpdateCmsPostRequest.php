<?php

namespace App\Http\Requests;

use App\Models\CmsPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCmsPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cms_post_edit');
    }

    public function rules()
    {
        return [
            'type_id' => [
                'required',
                'integer',
            ],
            'post_title' => [
                'string',
                'required',
            ],
            'post_name' => [
                'string',
                'nullable',
            ],
            'post_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'post_status' => [
                'required',
            ],
            'post_password' => [
                'string',
                'nullable',
            ],
        ];
    }
}
