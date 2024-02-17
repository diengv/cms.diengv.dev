<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCmsPostRequest;
use App\Http\Requests\UpdateCmsPostRequest;
use App\Http\Resources\Admin\CmsPostResource;
use App\Models\CmsPost;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsPostApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('cms_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsPostResource(CmsPost::with(['type', 'thumbnail', 'team'])->get());
    }

    public function store(StoreCmsPostRequest $request)
    {
        $cmsPost = CmsPost::create($request->all());

        return (new CmsPostResource($cmsPost))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CmsPost $cmsPost)
    {
        abort_if(Gate::denies('cms_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CmsPostResource($cmsPost->load(['type', 'thumbnail', 'team']));
    }

    public function update(UpdateCmsPostRequest $request, CmsPost $cmsPost)
    {
        $cmsPost->update($request->all());

        return (new CmsPostResource($cmsPost))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CmsPost $cmsPost)
    {
        abort_if(Gate::denies('cms_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsPost->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
