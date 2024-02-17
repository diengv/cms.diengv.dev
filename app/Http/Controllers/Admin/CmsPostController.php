<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCmsPostRequest;
use App\Http\Requests\StoreCmsPostRequest;
use App\Http\Requests\UpdateCmsPostRequest;
use App\Models\Asset;
use App\Models\CmsContenType;
use App\Models\CmsPost;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsPostController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsPost::with(['type', 'thumbnail', 'team'])->select(sprintf('%s.*', (new CmsPost)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_post_show';
                $editGate      = 'cms_post_edit';
                $deleteGate    = 'cms_post_delete';
                $crudRoutePart = 'cms-posts';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->editColumn('post_title', function ($row) {
                return $row->post_title ? $row->post_title : '';
            });
            $table->editColumn('post_name', function ($row) {
                return $row->post_name ? $row->post_name : '';
            });

            $table->editColumn('post_status', function ($row) {
                return $row->post_status ? CmsPost::POST_STATUS_SELECT[$row->post_status] : '';
            });
            $table->editColumn('comment_status', function ($row) {
                return $row->comment_status ? CmsPost::COMMENT_STATUS_RADIO[$row->comment_status] : '';
            });
            $table->editColumn('post_password', function ($row) {
                return $row->post_password ? $row->post_password : '';
            });
            $table->addColumn('thumbnail_name', function ($row) {
                return $row->thumbnail ? $row->thumbnail->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'type', 'thumbnail']);

            return $table->make(true);
        }

        $cms_conten_types = CmsContenType::get();
        $assets           = Asset::get();
        $teams            = Team::get();

        return view('admin.cmsPosts.index', compact('cms_conten_types', 'assets', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('cms_post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = CmsContenType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $thumbnails = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cmsPosts.create', compact('thumbnails', 'types'));
    }

    public function store(StoreCmsPostRequest $request)
    {
        $cmsPost = CmsPost::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cmsPost->id]);
        }

        return redirect()->route('admin.cms-posts.index');
    }

    public function edit(CmsPost $cmsPost)
    {
        abort_if(Gate::denies('cms_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = CmsContenType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $thumbnails = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cmsPost->load('type', 'thumbnail', 'team');

        return view('admin.cmsPosts.edit', compact('cmsPost', 'thumbnails', 'types'));
    }

    public function update(UpdateCmsPostRequest $request, CmsPost $cmsPost)
    {
        $cmsPost->update($request->all());

        return redirect()->route('admin.cms-posts.index');
    }

    public function show(CmsPost $cmsPost)
    {
        abort_if(Gate::denies('cms_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsPost->load('type', 'thumbnail', 'team', 'postCmsContentMeta');

        return view('admin.cmsPosts.show', compact('cmsPost'));
    }

    public function destroy(CmsPost $cmsPost)
    {
        abort_if(Gate::denies('cms_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsPost->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsPostRequest $request)
    {
        $cmsPosts = CmsPost::find(request('ids'));

        foreach ($cmsPosts as $cmsPost) {
            $cmsPost->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cms_post_create') && Gate::denies('cms_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CmsPost();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
