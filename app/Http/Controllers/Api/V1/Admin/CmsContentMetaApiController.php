<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCmsContentMetumRequest;
use App\Http\Requests\UpdateCmsContentMetumRequest;
use App\Http\Resources\Admin\CmsContentMetumResource;
use App\Models\CmsContentMetum;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsContentMetaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cms_content_metum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsContentMetumResource(CmsContentMetum::with(['post', 'assets', 'team'])->get());
    }

    public function store(StoreCmsContentMetumRequest $request)
    {
        $cmsContentMetum = CmsContentMetum::create($request->all());
        $cmsContentMetum->assets()->sync($request->input('assets', []));

        return (new CmsContentMetumResource($cmsContentMetum))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsContentMetum $cmsContentMetum)
    {
        abort_if(Gate::denies('cms_content_metum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsContentMetumResource($cmsContentMetum->load(['post', 'assets', 'team']));
    }

    public function update(UpdateCmsContentMetumRequest $request, CmsContentMetum $cmsContentMetum)
    {
        $cmsContentMetum->update($request->all());
        $cmsContentMetum->assets()->sync($request->input('assets', []));

        return (new CmsContentMetumResource($cmsContentMetum))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsContentMetum $cmsContentMetum)
    {
        abort_if(Gate::denies('cms_content_metum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContentMetum->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
