<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCmsContentMetumRequest;
use App\Http\Requests\StoreCmsContentMetumRequest;
use App\Http\Requests\UpdateCmsContentMetumRequest;
use App\Models\Asset;
use App\Models\CmsContentMetum;
use App\Models\CmsPost;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsContentMetaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_content_metum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsContentMetum::with(['post', 'assets', 'team'])->select(sprintf('%s.*', (new CmsContentMetum)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_content_metum_show';
                $editGate      = 'cms_content_metum_edit';
                $deleteGate    = 'cms_content_metum_delete';
                $crudRoutePart = 'cms-content-meta';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('value', function ($row) {
                return $row->value ? $row->value : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : '';
            });
            $table->addColumn('post_post_title', function ($row) {
                return $row->post ? $row->post->post_title : '';
            });

            $table->editColumn('asset', function ($row) {
                $labels = [];
                foreach ($row->assets as $asset) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $asset->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'post', 'asset']);

            return $table->make(true);
        }

        $cms_posts = CmsPost::get();
        $assets    = Asset::get();
        $teams     = Team::get();

        return view('admin.cmsContentMeta.index', compact('cms_posts', 'assets', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('cms_content_metum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = CmsPost::pluck('post_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assets = Asset::pluck('name', 'id');

        return view('admin.cmsContentMeta.create', compact('assets', 'posts'));
    }

    public function store(StoreCmsContentMetumRequest $request)
    {
        $cmsContentMetum = CmsContentMetum::create($request->all());
        $cmsContentMetum->assets()->sync($request->input('assets', []));

        return redirect()->route('admin.cms-content-meta.index');
    }

    public function edit(CmsContentMetum $cmsContentMetum)
    {
        abort_if(Gate::denies('cms_content_metum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = CmsPost::pluck('post_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assets = Asset::pluck('name', 'id');

        $cmsContentMetum->load('post', 'assets', 'team');

        return view('admin.cmsContentMeta.edit', compact('assets', 'cmsContentMetum', 'posts'));
    }

    public function update(UpdateCmsContentMetumRequest $request, CmsContentMetum $cmsContentMetum)
    {
        $cmsContentMetum->update($request->all());
        $cmsContentMetum->assets()->sync($request->input('assets', []));

        return redirect()->route('admin.cms-content-meta.index');
    }

    public function show(CmsContentMetum $cmsContentMetum)
    {
        abort_if(Gate::denies('cms_content_metum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContentMetum->load('post', 'assets', 'team');

        return view('admin.cmsContentMeta.show', compact('cmsContentMetum'));
    }

    public function destroy(CmsContentMetum $cmsContentMetum)
    {
        abort_if(Gate::denies('cms_content_metum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContentMetum->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsContentMetumRequest $request)
    {
        $cmsContentMeta = CmsContentMetum::find(request('ids'));

        foreach ($cmsContentMeta as $cmsContentMetum) {
            $cmsContentMetum->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
