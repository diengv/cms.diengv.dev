<div class="m-3">
    @can('cms_term_taxonomy_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.cms-term-taxonomies.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.cmsTermTaxonomy.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.cmsTermTaxonomy.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-termCmsTermTaxonomies">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.term') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.taxonomy') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.parent') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.count') }}
                            </th>
                            <th>
                                {{ trans('cruds.cmsTermTaxonomy.fields.image') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cmsTermTaxonomies as $key => $cmsTermTaxonomy)
                            <tr data-entry-id="{{ $cmsTermTaxonomy->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->id ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->term->name ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->taxonomy->name ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->parent->count ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->count ?? '' }}
                                </td>
                                <td>
                                    {{ $cmsTermTaxonomy->image->name ?? '' }}
                                </td>
                                <td>
                                    @can('cms_term_taxonomy_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.cms-term-taxonomies.show', $cmsTermTaxonomy->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('cms_term_taxonomy_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.cms-term-taxonomies.edit', $cmsTermTaxonomy->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('cms_term_taxonomy_delete')
                                        <form action="{{ route('admin.cms-term-taxonomies.destroy', $cmsTermTaxonomy->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('cms_term_taxonomy_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cms-term-taxonomies.massDestroy') }}",
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
  let table = $('.datatable-termCmsTermTaxonomies:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection