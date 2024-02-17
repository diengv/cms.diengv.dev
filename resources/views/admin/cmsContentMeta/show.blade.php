@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsContentMetum.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-content-meta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsContentMetum->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.name') }}
                        </th>
                        <td>
                            {{ $cmsContentMetum->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.value') }}
                        </th>
                        <td>
                            {{ $cmsContentMetum->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.type') }}
                        </th>
                        <td>
                            {{ $cmsContentMetum->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.post') }}
                        </th>
                        <td>
                            {{ $cmsContentMetum->post->post_title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContentMetum.fields.asset') }}
                        </th>
                        <td>
                            @foreach($cmsContentMetum->assets as $key => $asset)
                                <span class="label label-info">{{ $asset->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-content-meta.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection