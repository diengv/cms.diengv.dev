<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCmsTermRequest;
use App\Http\Requests\StoreCmsTermRequest;
use App\Http\Requests\UpdateCmsTermRequest;
use App\Models\CmsTerm;
use App\Models\Team;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsTermController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_term_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsTerm::with(['team'])->select(sprintf('%s.*', (new CmsTerm)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_term_show';
                $editGate      = 'cms_term_edit';
                $deleteGate    = 'cms_term_delete';
                $crudRoutePart = 'cms-terms';

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
            $table->editColumn('term_group', function ($row) {
                return $row->term_group ? $row->term_group : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $teams = Team::get();

        return view('admin.cmsTerms.index', compact('teams'));
    }

    public function create()
    {
        abort_if(Gate::denies('cms_term_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cmsTerms.create');
    }

    public function store(StoreCmsTermRequest $request)
    {
        $cmsTerm = CmsTerm::create($request->all());

        return redirect()->route('admin.cms-terms.index');
    }

    public function edit(CmsTerm $cmsTerm)
    {
        abort_if(Gate::denies('cms_term_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTerm->load('team');

        return view('admin.cmsTerms.edit', compact('cmsTerm'));
    }

    public function update(UpdateCmsTermRequest $request, CmsTerm $cmsTerm)
    {
        $cmsTerm->update($request->all());

        return redirect()->route('admin.cms-terms.index');
    }

    public function show(CmsTerm $cmsTerm)
    {
        abort_if(Gate::denies('cms_term_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTerm->load('team', 'termCmsTermTaxonomies');

        return view('admin.cmsTerms.show', compact('cmsTerm'));
    }

    public function destroy(CmsTerm $cmsTerm)
    {
        abort_if(Gate::denies('cms_term_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsTerm->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsTermRequest $request)
    {
        $cmsTerms = CmsTerm::find(request('ids'));

        foreach ($cmsTerms as $cmsTerm) {
            $cmsTerm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
