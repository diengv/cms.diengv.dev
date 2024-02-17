<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCmsTaxonomyRequest;
use App\Http\Requests\UpdateCmsTaxonomyRequest;
use App\Http\Resources\Admin\CmsTaxonomyResource;
use App\Models\CmsTaxonomy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsTaxonomyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cms_taxonomy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTaxonomyResource(CmsTaxonomy::with(['image', 'team'])->get());
    }

    public function store(StoreCmsTaxonomyRequest $request)
    {
        $cmsTaxonomy = CmsTaxonomy::create($request->all());

        return (new CmsTaxonomyResource($cmsTaxonomy))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsTaxonomy $cmsTaxonomy)
    {
        abort_if(Gate::denies('cms_taxonomy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTaxonomyResource($cmsTaxonomy->load(['image', 'team']));
    }

    public function update(UpdateCmsTaxonomyRequest $request, CmsTaxonomy $cmsTaxonomy)
    {
        $cmsTaxonomy->update($request->all());

        return (new CmsTaxonomyResource($cmsTaxonomy))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsTaxonomy $cmsTaxonomy)
    {
        abort_if(Gate::denies('cms_taxonomy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTaxonomy->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
