@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsTaxonomy.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-taxonomies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsTaxonomy->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.name') }}
                        </th>
                        <td>
                            {{ $cmsTaxonomy->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.slug') }}
                        </th>
                        <td>
                            {{ $cmsTaxonomy->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.description') }}
                        </th>
                        <td>
                            {{ $cmsTaxonomy->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.hierarchical') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $cmsTaxonomy->hierarchical ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTaxonomy.fields.image') }}
                        </th>
                        <td>
                            {{ $cmsTaxonomy->image->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-taxonomies.index') }}">
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
            <a class="nav-link" href="#taxonomy_cms_term_taxonomies" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTermTaxonomy.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="taxonomy_cms_term_taxonomies">
            @includeIf('admin.cmsTaxonomies.relationships.taxonomyCmsTermTaxonomies', ['cmsTermTaxonomies' => $cmsTaxonomy->taxonomyCmsTermTaxonomies])
        </div>
    </div>
</div>

@endsection