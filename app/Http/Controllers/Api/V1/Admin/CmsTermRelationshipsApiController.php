<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCmsTermRelationshipRequest;
use App\Http\Requests\UpdateCmsTermRelationshipRequest;
use App\Http\Resources\Admin\CmsTermRelationshipResource;
use App\Models\CmsTermRelationship;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsTermRelationshipsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cms_term_relationship_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermRelationshipResource(CmsTermRelationship::with(['term_taxonomy', 'team'])->get());
    }

    public function store(StoreCmsTermRelationshipRequest $request)
    {
        $cmsTermRelationship = CmsTermRelationship::create($request->all());

        return (new CmsTermRelationshipResource($cmsTermRelationship))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsTermRelationship $cmsTermRelationship)
    {
        abort_if(Gate::denies('cms_term_relationship_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermRelationshipResource($cmsTermRelationship->load(['term_taxonomy', 'team']));
    }

    public function update(UpdateCmsTermRelationshipRequest $request, CmsTermRelationship $cmsTermRelationship)
    {
        $cmsTermRelationship->update($request->all());

        return (new CmsTermRelationshipResource($cmsTermRelationship))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsTermRelationship $cmsTermRelationship)
    {
        abort_if(Gate::denies('cms_term_relationship_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermRelationship->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
