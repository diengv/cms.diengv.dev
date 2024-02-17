<div class="m-3">
    @can('cms_content_metum_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.cms-content-meta.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.cmsContentMetum.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.cmsContentMetum.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-postCmsContentMeta">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.name') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.value') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.post') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsContentMetum.fields.asset') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cmsContentMeta as $key => $cmsContentMetum)
                            <tr data-entry-id="{{ $cmsContentMetum->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $cmsContentMetum->id ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsContentMetum->name ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsContentMetum->value ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsContentMetum->type ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsContentMetum->post->post_title ?? '' }}
                                </td>
                                <td>
                                    @foreach($cmsContentMetum->assets as $key => $item)
                                        <span class="badge badge-info">{{ $item->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('cms_content_metum_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.cms-content-meta.show', $cmsContentMetum->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('cms_content_metum_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.cms-content-meta.edit', $cmsContentMetum->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('cms_content_metum_delete')
                                        <form action="{{ route('admin.cms-content-meta.destroy', $cmsContentMetum->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('cms_content_metum_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cms-content-meta.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-postCmsContentMeta:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection