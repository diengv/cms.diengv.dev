@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cmsTermRelationship.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-term-relationships.update", [$cmsTermRelationship->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="object">{{ trans('cruds.cmsTermRelationship.fields.object') }}</label>
                <input class="form-control {{ $errors->has('object') ? 'is-invalid' : '' }}" type="number" name="object" id="object" value="{{ old('object', $cmsTermRelationship->object) }}" step="1" required>
                @if($errors->has('object'))
                    <span class="text-danger">{{ $errors->first('object') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermRelationship.fields.object_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="term_taxonomy_id">{{ trans('cruds.cmsTermRelationship.fields.term_taxonomy') }}</label>
                <select class="form-control select2 {{ $errors->has('term_taxonomy') ? 'is-invalid' : '' }}" name="term_taxonomy_id" id="term_taxonomy_id" required>
                    @foreach($term_taxonomies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('term_taxonomy_id') ? old('term_taxonomy_id') : $cmsTermRelationship->term_taxonomy->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('term_taxonomy'))
                    <span class="text-danger">{{ $errors->first('term_taxonomy') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermRelationship.fields.term_taxonomy_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_order">{{ trans('cruds.cmsTermRelationship.fields.term_order') }}</label>
                <input class="form-control {{ $errors->has('term_order') ? 'is-invalid' : '' }}" type="number" name="term_order" id="term_order" value="{{ old('term_order', $cmsTermRelationship->term_order) }}" step="1">
                @if($errors->has('term_order'))
                    <span class="text-danger">{{ $errors->first('term_order') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermRelationship.fields.term_order_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection