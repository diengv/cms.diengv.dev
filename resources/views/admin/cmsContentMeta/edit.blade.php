@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cmsContentMetum.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-content-meta.update", [$cmsContentMetum->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.cmsContentMetum.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $cmsContentMetum->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsContentMetum.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="value">{{ trans('cruds.cmsContentMetum.fields.value') }}</label>
                <textarea class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" id="value">{{ old('value', $cmsContentMetum->value) }}</textarea>
                @if($errors->has('value'))
                    <span class="text-danger">{{ $errors->first('value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsContentMetum.fields.value_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.cmsContentMetum.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $cmsContentMetum->type) }}" required>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsContentMetum.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.cmsContentMetum.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('post_id') ? old('post_id') : $cmsContentMetum->post->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsContentMetum.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="assets">{{ trans('cruds.cmsContentMetum.fields.asset') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('assets') ? 'is-invalid' : '' }}" name="assets[]" id="assets" multiple>
                    @foreach($assets as $id => $asset)
                        <option value="{{ $id }}" {{ (in_array($id, old('assets', [])) || $cmsContentMetum->assets->contains($id)) ? 'selected' : '' }}>{{ $asset }}</option>
                    @endforeach
                </select>
                @if($errors->has('assets'))
                    <span class="text-danger">{{ $errors->first('assets') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsContentMetum.fields.asset_helper') }}</span>
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