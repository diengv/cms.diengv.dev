@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cmsTaxonomy.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-taxonomies.update", [$cmsTaxonomy->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.cmsTaxonomy.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $cmsTaxonomy->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTaxonomy.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="slug">{{ trans('cruds.cmsTaxonomy.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $cmsTaxonomy->slug) }}">
                @if($errors->has('slug'))
                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTaxonomy.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.cmsTaxonomy.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $cmsTaxonomy->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTaxonomy.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image_id">{{ trans('cruds.cmsTaxonomy.fields.image') }}</label>
                <select class="form-control select2 {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image_id" id="image_id">
                    @foreach($images as $id => $entry)
                        <option value="{{ $id }}" {{ (old('image_id') ? old('image_id') : $cmsTaxonomy->image->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTaxonomy.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.cmsTaxonomy.fields.hierarchical') }}</label>
                @foreach(App\Models\CmsTaxonomy::HIERARCHICAL_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('hierarchical') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="hierarchical_{{ $key }}" name="hierarchical" value="{{ $key }}" {{ old('hierarchical', $cmsTaxonomy->hierarchical) === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="hierarchical_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('hierarchical'))
                    <span class="text-danger">{{ $errors->first('hierarchical') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTaxonomy.fields.hierarchical_helper') }}</span>
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