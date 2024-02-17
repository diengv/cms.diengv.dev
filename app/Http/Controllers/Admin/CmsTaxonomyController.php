<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCmsTaxonomyRequest;
use App\Http\Requests\StoreCmsTaxonomyRequest;
use App\Http\Requests\UpdateCmsTaxonomyRequest;
use App\Models\Asset;
use App\Models\CmsTaxonomy;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsTaxonomyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_taxonomy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsTaxonomy::with(['image', 'team'])->select(sprintf('%s.*', (new CmsTaxonomy)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_taxonomy_show';
                $editGate      = 'cms_taxonomy_edit';
                $deleteGate    = 'cms_taxonomy_delete';
                $crudRoutePart = 'cms-taxonomies';

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
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : '';
            });
            $table->addColumn('image_name', function ($row) {
                return $row->image ? $row->image->name : '';
            });

            $table->editColumn('hierarchical', function ($row) {
                return $row->hierarchical ? CmsTaxonomy::HIERARCHICAL_RADIO[$row->hierarchical] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.cmsTaxonomies.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cms_taxonomy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cmsTaxonomies.create', compact('images'));
    }

    public function store(StoreCmsTaxonomyRequest $request)
    {
        $cmsTaxonomy = CmsTaxonomy::create($request->all());

        return redirect()->route('admin.cms-taxonomies.index');
    }

    public function edit(CmsTaxonomy $cmsTaxonomy)
    {
        abort_if(Gate::denies('cms_taxonomy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cmsTaxonomy->load('image', 'team');

        return view('admin.cmsTaxonomies.edit', compact('cmsTaxonomy', 'images'));
    }

    public function update(UpdateCmsTaxonomyRequest $request, CmsTaxonomy $cmsTaxonomy)
    {
        $cmsTaxonomy->update($request->all());

        return redirect()->route('admin.cms-taxonomies.index');
    }

    public function show(CmsTaxonomy $cmsTaxonomy)
    {
        abort_if(Gate::denies('cms_taxonomy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTaxonomy->load('image', 'team', 'taxonomyCmsTermTaxonomies');

        return view('admin.cmsTaxonomies.show', compact('cmsTaxonomy'));
    }

    public function destroy(CmsTaxonomy $cmsTaxonomy)
    {
        abort_if(Gate::denies('cms_taxonomy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTaxonomy->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsTaxonomyRequest $request)
    {
        $cmsTaxonomies = CmsTaxonomy::find(request('ids'));

        foreach ($cmsTaxonomies as $cmsTaxonomy) {
            $cmsTaxonomy->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
