@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cmsTermTaxonomy.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-term-taxonomies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="term_id">{{ trans('cruds.cmsTermTaxonomy.fields.term') }}</label>
                <select class="form-control select2 {{ $errors->has('term') ? 'is-invalid' : '' }}" name="term_id" id="term_id" required>
                    @foreach($terms as $id => $entry)
                        <option value="{{ $id }}" {{ old('term_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('term'))
                    <span class="text-danger">{{ $errors->first('term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.term_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="taxonomy_id">{{ trans('cruds.cmsTermTaxonomy.fields.taxonomy') }}</label>
                <select class="form-control select2 {{ $errors->has('taxonomy') ? 'is-invalid' : '' }}" name="taxonomy_id" id="taxonomy_id" required>
                    @foreach($taxonomies as $id => $entry)
                        <option value="{{ $id }}" {{ old('taxonomy_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('taxonomy'))
                    <span class="text-danger">{{ $errors->first('taxonomy') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.taxonomy_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.cmsTermTaxonomy.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="parent_id">{{ trans('cruds.cmsTermTaxonomy.fields.parent') }}</label>
                <select class="form-control select2 {{ $errors->has('parent') ? 'is-invalid' : '' }}" name="parent_id" id="parent_id">
                    @foreach($parents as $id => $entry)
                        <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('parent'))
                    <span class="text-danger">{{ $errors->first('parent') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.parent_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="count">{{ trans('cruds.cmsTermTaxonomy.fields.count') }}</label>
                <input class="form-control {{ $errors->has('count') ? 'is-invalid' : '' }}" type="number" name="count" id="count" value="{{ old('count', '') }}" step="1">
                @if($errors->has('count'))
                    <span class="text-danger">{{ $errors->first('count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image_id">{{ trans('cruds.cmsTermTaxonomy.fields.image') }}</label>
                <select class="form-control select2 {{ $errors->has('image') ? 'is-invalid' : '' }}" name="image_id" id="image_id">
                    @foreach($images as $id => $entry)
                        <option value="{{ $id }}" {{ old('image_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsTermTaxonomy.fields.image_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.cms-term-taxonomies.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $cmsTermTaxonomy->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection