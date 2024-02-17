@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.asset.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.id') }}
                        </th>
                        <td>
                            {{ $asset->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.category') }}
                        </th>
                        <td>
                            {{ $asset->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.serial_number') }}
                        </th>
                        <td>
                            {{ $asset->serial_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <td>
                            {{ $asset->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.photos') }}
                        </th>
                        <td>
                            @foreach($asset->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.status') }}
                        </th>
                        <td>
                            {{ $asset->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.location') }}
                        </th>
                        <td>
                            {{ $asset->location->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.notes') }}
                        </th>
                        <td>
                            {{ $asset->notes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.assigned_to') }}
                        </th>
                        <td>
                            {{ $asset->assigned_to->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
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
            <a class="nav-link" href="#thumbnail_cms_posts" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsPost.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#image_cms_conten_types" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsContenType.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#image_cms_taxonomies" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTaxonomy.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#image_cms_term_taxonomies" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsTermTaxonomy.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#asset_cms_content_meta" role="tab" data-toggle="tab">
                {{ trans('cruds.cmsContentMetum.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="thumbnail_cms_posts">
            @includeIf('admin.assets.relationships.thumbnailCmsPosts', ['cmsPosts' => $asset->thumbnailCmsPosts])
        </div>
        <div class="tab-pane" role="tabpanel" id="image_cms_conten_types">
            @includeIf('admin.assets.relationships.imageCmsContenTypes', ['cmsContenTypes' => $asset->imageCmsContenTypes])
        </div>
        <div class="tab-pane" role="tabpanel" id="image_cms_taxonomies">
            @includeIf('admin.assets.relationships.imageCmsTaxonomies', ['cmsTaxonomies' => $asset->imageCmsTaxonomies])
        </div>
        <div class="tab-pane" role="tabpanel" id="image_cms_term_taxonomies">
            @includeIf('admin.assets.relationships.imageCmsTermTaxonomies', ['cmsTermTaxonomies' => $asset->imageCmsTermTaxonomies])
        </div>
        <div class="tab-pane" role="tabpanel" id="asset_cms_content_meta">
            @includeIf('admin.assets.relationships.assetCmsContentMeta', ['cmsContentMeta' => $asset->assetCmsContentMeta])
        </div>
    </div>
</div>

@endsection