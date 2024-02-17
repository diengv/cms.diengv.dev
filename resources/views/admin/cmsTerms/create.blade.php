@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cmsTerm.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-terms.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.cmsTerm.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTerm.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="slug">{{ trans('cruds.cmsTerm.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}">
                @if($errors->has('slug'))
                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTerm.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_group">{{ trans('cruds.cmsTerm.fields.term_group') }}</label>
                <input class="form-control {{ $errors->has('term_group') ? 'is-invalid' : '' }}" type="text" name="term_group" id="term_group" value="{{ old('term_group', '') }}">
                @if($errors->has('term_group'))
                    <span class="text-danger">{{ $errors->first('term_group') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTerm.fields.term_group_helper') }}</span>
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