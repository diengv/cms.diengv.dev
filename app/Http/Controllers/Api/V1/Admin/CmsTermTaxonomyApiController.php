<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCmsTermTaxonomyRequest;
use App\Http\Requests\UpdateCmsTermTaxonomyRequest;
use App\Http\Resources\Admin\CmsTermTaxonomyResource;
use App\Models\CmsTermTaxonomy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsTermTaxonomyApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cms_term_taxonomy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermTaxonomyResource(CmsTermTaxonomy::with(['term', 'taxonomy', 'parent', 'image', 'team'])->get());
    }

    public function store(StoreCmsTermTaxonomyRequest $request)
    {
        $cmsTermTaxonomy = CmsTermTaxonomy::create($request->all());

        return (new CmsTermTaxonomyResource($cmsTermTaxonomy))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsTermTaxonomy $cmsTermTaxonomy)
    {
        abort_if(Gate::denies('cms_term_taxonomy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermTaxonomyResource($cmsTermTaxonomy->load(['term', 'taxonomy', 'parent', 'image', 'team']));
    }

    public function update(UpdateCmsTermTaxonomyRequest $request, CmsTermTaxonomy $cmsTermTaxonomy)
    {
        $cmsTermTaxonomy->update($request->all());

        return (new CmsTermTaxonomyResource($cmsTermTaxonomy))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsTermTaxonomy $cmsTermTaxonomy)
    {
        abort_if(Gate::denies('cms_term_taxonomy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermTaxonomy->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
