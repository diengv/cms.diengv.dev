@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsTermRelationship.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-term-relationships.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermRelationship.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsTermRelationship->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermRelationship.fields.object') }}
                        </th>
                        <td>
                            {{ $cmsTermRelationship->object }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermRelationship.fields.term_taxonomy') }}
                        </th>
                        <td>
                            {{ $cmsTermRelationship->term_taxonomy->count ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermRelationship.fields.term_order') }}
                        </th>
                        <td>
                            {{ $cmsTermRelationship->term_order }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-term-relationships.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection