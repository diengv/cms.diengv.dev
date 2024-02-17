@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsContenType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-conten-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContenType.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsContenType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContenType.fields.name') }}
                        </th>
                        <td>
                            {{ $cmsContenType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContenType.fields.description') }}
                        </th>
                        <td>
                            {{ $cmsContenType->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsContenType.fields.image') }}
                        </th>
                        <td>
                            {{ $cmsContenType->image->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-conten-types.index') }}">
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
            <a class="nav-link" href="#type_cms_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsPost.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="type_cms_posts">
            @includeIf('admin.cmsContenTypes.relationships.typeCmsPosts', ['cmsPosts' => $cmsContenType->typeCmsPosts])
        </div>
    </div>
</div>

@endsection