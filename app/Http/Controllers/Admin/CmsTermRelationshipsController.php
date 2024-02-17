<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCmsTermRelationshipRequest;
use App\Http\Requests\StoreCmsTermRelationshipRequest;
use App\Http\Requests\UpdateCmsTermRelationshipRequest;
use App\Models\CmsTermRelationship;
use App\Models\CmsTermTaxonomy;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsTermRelationshipsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_term_relationship_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsTermRelationship::with(['term_taxonomy', 'team'])->select(sprintf('%s.*', (new CmsTermRelationship)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_term_relationship_show';
                $editGate      = 'cms_term_relationship_edit';
                $deleteGate    = 'cms_term_relationship_delete';
                $crudRoutePart = 'cms-term-relationships';

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
            $table->editColumn('object', function ($row) {
                return $row->object ? $row->object : '';
            });
            $table->addColumn('term_taxonomy_count', function ($row) {
                return $row->term_taxonomy ? $row->term_taxonomy->count : '';
            });

            $table->editColumn('term_order', function ($row) {
                return $row->term_order ? $row->term_order : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'term_taxonomy']);

            return $table->make(true);
        }

        $cms_term_taxonomies = CmsTermTaxonomy::get();
        $teams               = Team::get();

        return view('admin.cmsTermRelationships.index', compact('cms_term_taxonomies', 'teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('cms_term_relationship_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $term_taxonomies = CmsTermTaxonomy::pluck('count', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cmsTermRelationships.create', compact('term_taxonomies'));
    }

    public function store(StoreCmsTermRelationshipRequest $request)
    {
        $cmsTermRelationship = CmsTermRelationship::create($request->all());

        return redirect()->route('admin.cms-term-relationships.index');
    }

    public function edit(CmsTermRelationship $cmsTermRelationship)
    {
        abort_if(Gate::denies('cms_term_relationship_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $term_taxonomies = CmsTermTaxonomy::pluck('count', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cmsTermRelationship->load('term_taxonomy', 'team');

        return view('admin.cmsTermRelationships.edit', compact('cmsTermRelationship', 'term_taxonomies'));
    }

    public function update(UpdateCmsTermRelationshipRequest $request, CmsTermRelationship $cmsTermRelationship)
    {
        $cmsTermRelationship->update($request->all());

        return redirect()->route('admin.cms-term-relationships.index');
    }

    public function show(CmsTermRelationship $cmsTermRelationship)
    {
        abort_if(Gate::denies('cms_term_relationship_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermRelationship->load('term_taxonomy', 'team');

        return view('admin.cmsTermRelationships.show', compact('cmsTermRelationship'));
    }

    public function destroy(CmsTermRelationship $cmsTermRelationship)
    {
        abort_if(Gate::denies('cms_term_relationship_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTermRelationship->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsTermRelationshipRequest $request)
    {
        $cmsTermRelationships = CmsTermRelationship::find(request('ids'));

        foreach ($cmsTermRelationships as $cmsTermRelationship) {
            $cmsTermRelationship->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
