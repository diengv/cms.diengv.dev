@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsPost.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsPost->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.type') }}
                        </th>
                        <td>
                            {{ $cmsPost->type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_title') }}
                        </th>
                        <td>
                            {{ $cmsPost->post_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_name') }}
                        </th>
                        <td>
                            {{ $cmsPost->post_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_content') }}
                        </th>
                        <td>
                            {!! $cmsPost->post_content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_date') }}
                        </th>
                        <td>
                            {{ $cmsPost->post_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_excerpt') }}
                        </th>
                        <td>
                            {{ $cmsPost->post_excerpt }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_status') }}
                        </th>
                        <td>
                            {{ App\Models\CmsPost::POST_STATUS_SELECT[$cmsPost->post_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.comment_status') }}
                        </th>
                        <td>
                            {{ App\Models\CmsPost::COMMENT_STATUS_RADIO[$cmsPost->comment_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.post_password') }}
                        </th>
                        <td>
                            {{ $cmsPost->post_password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsPost.fields.thumbnail') }}
                        </th>
                        <td>
                            {{ $cmsPost->thumbnail->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#post_cms_content_meta" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsContentMetum.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="post_cms_content_meta">
            @includeIf('admin.cmsPosts.relationships.postCmsContentMeta', ['cmsContentMeta' => $cmsPost->postCmsContentMeta])
        </div>
    </div>
</div>

@endsection