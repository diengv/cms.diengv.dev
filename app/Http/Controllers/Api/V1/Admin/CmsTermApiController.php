<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCmsTermRequest;
use App\Http\Requests\UpdateCmsTermRequest;
use App\Http\Resources\Admin\CmsTermResource;
use App\Models\CmsTerm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsTermApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cms_term_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermResource(CmsTerm::with(['team'])->get());
    }

    public function store(StoreCmsTermRequest $request)
    {
        $cmsTerm = CmsTerm::create($request->all());

        return (new CmsTermResource($cmsTerm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsTerm $cmsTerm)
    {
        abort_if(Gate::denies('cms_term_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsTermResource($cmsTerm->load(['team']));
    }

    public function update(UpdateCmsTermRequest $request, CmsTerm $cmsTerm)
    {
        $cmsTerm->update($request->all());

        return (new CmsTermResource($cmsTerm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsTerm $cmsTerm)
    {
        abort_if(Gate::denies('cms_term_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTerm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
