@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cmsTerm.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-terms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTerm.fields.id') }}
                        </th>
                        <td>
                            {{ $cmsTerm->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTerm.fields.name') }}
                        </th>
                        <td>
                            {{ $cmsTerm->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTerm.fields.slug') }}
                        </th>
                        <td>
                            {{ $cmsTerm->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cmsTerm.fields.term_group') }}
                        </th>
                        <td>
                            {{ $cmsTerm->term_group }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cms-terms.index') }}">
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
            <a class="nav-link" href="#term_cms_term_taxonomies" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTermTaxonomy.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="term_cms_term_taxonomies">
            @includeIf('admin.cmsTerms.relationships.termCmsTermTaxonomies', ['cmsTermTaxonomies' => $cmsTerm->termCmsTermTaxonomies])
        </div>
    </div>
</div>

@endsection