@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsTermTaxonomy.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-term-taxonomies.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.term') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->term->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.taxonomy') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->taxonomy->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.description') }}
                        </th>
                        <td>
                            {!! $cmsTermTaxonomy->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.parent') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->parent->count ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.count') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTermTaxonomy.fields.image') }}
                        </th>
                        <td>
                            {{ $cmsTermTaxonomy->image->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-term-taxonomies.index') }}">
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
            <a class="nav-link" href="#parent_cms_term_taxonomies" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTermTaxonomy.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#term_taxonomy_cms_term_relationships" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTermRelationship.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="parent_cms_term_taxonomies">
            @includeIf('admin.cmsTermTaxonomies.relationships.parentCmsTermTaxonomies', ['cmsTermTaxonomies' => $cmsTermTaxonomy->parentCmsTermTaxonomies])
        </div>
        <div class="tab-pane" role="tabpanel" id="term_taxonomy_cms_term_relationships">
            @includeIf('admin.cmsTermTaxonomies.relationships.termTaxonomyCmsTermRelationships', ['cmsTermRelationships' => $cmsTermTaxonomy->termTaxonomyCmsTermRelationships])
        </div>
    </div>
</div>

@endsection