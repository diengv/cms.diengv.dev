@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cmsPost.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cms-posts.update", [$cmsPost->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.cmsPost.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('type_id') ? old('type_id') : $cmsPost->type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="post_title">{{ trans('cruds.cmsPost.fields.post_title') }}</label>
                <input class="form-control {{ $errors->has('post_title') ? 'is-invalid' : '' }}" type="text" name="post_title" id="post_title" value="{{ old('post_title', $cmsPost->post_title) }}" required>
                @if($errors->has('post_title'))
                    <span class="text-danger">{{ $errors->first('post_title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_name">{{ trans('cruds.cmsPost.fields.post_name') }}</label>
                <input class="form-control {{ $errors->has('post_name') ? 'is-invalid' : '' }}" type="text" name="post_name" id="post_name" value="{{ old('post_name', $cmsPost->post_name) }}">
                @if($errors->has('post_name'))
                    <span class="text-danger">{{ $errors->first('post_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_content">{{ trans('cruds.cmsPost.fields.post_content') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('post_content') ? 'is-invalid' : '' }}" name="post_content" id="post_content">{!! old('post_content', $cmsPost->post_content) !!}</textarea>
                @if($errors->has('post_content'))
                    <span class="text-danger">{{ $errors->first('post_content') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_date">{{ trans('cruds.cmsPost.fields.post_date') }}</label>
                <input class="form-control datetime {{ $errors->has('post_date') ? 'is-invalid' : '' }}" type="text" name="post_date" id="post_date" value="{{ old('post_date', $cmsPost->post_date) }}">
                @if($errors->has('post_date'))
                    <span class="text-danger">{{ $errors->first('post_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_excerpt">{{ trans('cruds.cmsPost.fields.post_excerpt') }}</label>
                <textarea class="form-control {{ $errors->has('post_excerpt') ? 'is-invalid' : '' }}" name="post_excerpt" id="post_excerpt">{{ old('post_excerpt', $cmsPost->post_excerpt) }}</textarea>
                @if($errors->has('post_excerpt'))
                    <span class="text-danger">{{ $errors->first('post_excerpt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_excerpt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.cmsPost.fields.post_status') }}</label>
                <select class="form-control {{ $errors->has('post_status') ? 'is-invalid' : '' }}" name="post_status" id="post_status" required>
                    <option value disabled {{ old('post_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CmsPost::POST_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('post_status', $cmsPost->post_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('post_status'))
                    <span class="text-danger">{{ $errors->first('post_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.cmsPost.fields.comment_status') }}</label>
                @foreach(App\Models\CmsPost::COMMENT_STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('comment_status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="comment_status_{{ $key }}" name="comment_status" value="{{ $key }}" {{ old('comment_status', $cmsPost->comment_status) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="comment_status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('comment_status'))
                    <span class="text-danger">{{ $errors->first('comment_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.comment_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post_password">{{ trans('cruds.cmsPost.fields.post_password') }}</label>
                <input class="form-control {{ $errors->has('post_password') ? 'is-invalid' : '' }}" type="text" name="post_password" id="post_password" value="{{ old('post_password', $cmsPost->post_password) }}">
                @if($errors->has('post_password'))
                    <span class="text-danger">{{ $errors->first('post_password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.post_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="thumbnail_id">{{ trans('cruds.cmsPost.fields.thumbnail') }}</label>
                <select class="form-control select2 {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}" name="thumbnail_id" id="thumbnail_id">
                    @foreach($thumbnails as $id => $entry)
                        <option value="{{ $id }}" {{ (old('thumbnail_id') ? old('thumbnail_id') : $cmsPost->thumbnail->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('thumbnail'))
                    <span class="text-danger">{{ $errors->first('thumbnail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cmsPost.fields.thumbnail_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.cms-posts.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $cmsPost->id ?? 0 }}');
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