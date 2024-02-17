<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCmsTermTaxonomyRequest;
use App\Http\Requests\StoreCmsTermTaxonomyRequest;
use App\Http\Requests\UpdateCmsTermTaxonomyRequest;
use App\Models\Asset;
use App\Models\CmsTaxonomy;
use App\Models\CmsTerm;
use App\Models\CmsTermTaxonomy;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsTermTaxonomyController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_term_taxonomy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsTermTaxonomy::with(['term', 'taxonomy', 'parent', 'image', 'team'])->select(sprintf('%s.*', (new CmsTermTaxonomy)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_term_taxonomy_show';
                $editGate      = 'cms_term_taxonomy_edit';
                $deleteGate    = 'cms_term_taxonomy_delete';
                $crudRoutePart = 'cms-term-taxonomies';

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
            $table->addColumn('term_name', function ($row) {
                return $row->term ? $row->term->name : '';
            });

            $table->addColumn('taxonomy_name', function ($row) {
                return $row->taxonomy ? $row->taxonomy->name : '';
            });

            $table->addColumn('parent_count', function ($row) {
                return $row->parent ? $row->parent->count : '';
            });

            $table->editColumn('count', function ($row) {
                return $row->count ? $row->count : '';
            });
            $table->addColumn('image_name', function ($row) {
                return $row->image ? $row->image->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'term', 'taxonomy', 'parent', 'image']);

            return $table->make(true);
        }

        $cms_terms           = CmsTerm::get();
        $cms_taxonomies      = CmsTaxonomy::get();
        $cms_term_taxonomies = CmsTermTaxonomy::get();
        $assets              = Asset::get();
        $teams               = Team::get();

        return view('admin.cmsTermTaxonomies.index', compact('cms_terms', 'cms_taxonomies', 'cms_term_taxonomies', 'assets', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('cms_term_taxonomy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $terms = CmsTerm::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $taxonomies = CmsTaxonomy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $parents = CmsTermTaxonomy::pluck('count', 'id')->prepend(trans('global.pleaseSelect'), '');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cmsTermTaxonomies.create', compact('images', 'parents', 'taxonomies', 'terms'));
    }

    public function store(StoreCmsTermTaxonomyRequest $request)
    {
        $cmsTermTaxonomy = CmsTermTaxonomy::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $cmsTermTaxonomy->id]);
        }

        return redirect()->route('admin.cms-term-taxonomies.index');
    }

    public function edit(CmsTermTaxonomy $cmsTermTaxonomy)
    {
        abort_if(Gate::denies('cms_term_taxonomy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $terms = CmsTerm::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $taxonomies = CmsTaxonomy::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $parents = CmsTermTaxonomy::pluck('count', 'id')->prepend(trans('global.pleaseSelect'), '');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cmsTermTaxonomy->load('term', 'taxonomy', 'parent', 'image', 'team');

        return view('admin.cmsTermTaxonomies.edit', compact('cmsTermTaxonomy', 'images', 'parents', 'taxonomies', 'terms'));
    }

    public function update(UpdateCmsTermTaxonomyRequest $request, CmsTermTaxonomy $cmsTermTaxonomy)
    {
        $cmsTermTaxonomy->update($request->all());

        return redirect()->route('admin.cms-term-taxonomies.index');
    }

    public function show(CmsTermTaxonomy $cmsTermTaxonomy)
    {
        abort_if(Gate::denies('cms_term_taxonomy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermTaxonomy->load('term', 'taxonomy', 'parent', 'image', 'team', 'parentCmsTermTaxonomies', 'termTaxonomyCmsTermRelationships');

        return view('admin.cmsTermTaxonomies.show', compact('cmsTermTaxonomy'));
    }

    public function destroy(CmsTermTaxonomy $cmsTermTaxonomy)
    {
        abort_if(Gate::denies('cms_term_taxonomy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermTaxonomy->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsTermTaxonomyRequest $request)
    {
        $cmsTermTaxonomies = CmsTermTaxonomy::find(request('ids'));

        foreach ($cmsTermTaxonomies as $cmsTermTaxonomy) {
            $cmsTermTaxonomy->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('cms_term_taxonomy_create') && Gate::denies('cms_term_taxonomy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CmsTermTaxonomy();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
