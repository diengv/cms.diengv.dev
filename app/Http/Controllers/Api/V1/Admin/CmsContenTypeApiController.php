<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCmsContenTypeRequest;
use App\Http\Requests\UpdateCmsContenTypeRequest;
use App\Http\Resources\Admin\CmsContenTypeResource;
use App\Models\CmsContenType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsContenTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cms_conten_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsContenTypeResource(CmsContenType::with(['image', 'team'])->get());
    }

    public function store(StoreCmsContenTypeRequest $request)
    {
        $cmsContenType = CmsContenType::create($request->all());

        return (new CmsContenTypeResource($cmsContenType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsContenType $cmsContenType)
    {
        abort_if(Gate::denies('cms_conten_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsContenTypeResource($cmsContenType->load(['image', 'team']));
    }

    public function update(UpdateCmsContenTypeRequest $request, CmsContenType $cmsContenType)
    {
        $cmsContenType->update($request->all());

        return (new CmsContenTypeResource($cmsContenType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsContenType $cmsContenType)
    {
        abort_if(Gate::denies('cms_conten_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContenType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
