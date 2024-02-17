<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCmsContenTypeRequest;
use App\Http\Requests\StoreCmsContenTypeRequest;
use App\Http\Requests\UpdateCmsContenTypeRequest;
use App\Models\Asset;
use App\Models\CmsContenType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CmsContenTypeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('cms_conten_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CmsContenType::with(['image', 'team'])->select(sprintf('%s.*', (new CmsContenType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'cms_conten_type_show';
                $editGate      = 'cms_conten_type_edit';
                $deleteGate    = 'cms_conten_type_delete';
                $crudRoutePart = 'cms-conten-types';

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
            $table->addColumn('image_name', function ($row) {
                return $row->image ? $row->image->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.cmsContenTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('cms_conten_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cmsContenTypes.create', compact('images'));
    }

    public function store(StoreCmsContenTypeRequest $request)
    {
        $cmsContenType = CmsContenType::create($request->all());

        return redirect()->route('admin.cms-conten-types.index');
    }

    public function edit(CmsContenType $cmsContenType)
    {
        abort_if(Gate::denies('cms_conten_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $images = Asset::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cmsContenType->load('image', 'team');

        return view('admin.cmsContenTypes.edit', compact('cmsContenType', 'images'));
    }

    public function update(UpdateCmsContenTypeRequest $request, CmsContenType $cmsContenType)
    {
        $cmsContenType->update($request->all());

        return redirect()->route('admin.cms-conten-types.index');
    }

    public function show(CmsContenType $cmsContenType)
    {
        abort_if(Gate::denies('cms_conten_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContenType->load('image', 'team', 'typeCmsPosts');

        return view('admin.cmsContenTypes.show', compact('cmsContenType'));
    }

    public function destroy(CmsContenType $cmsContenType)
    {
        abort_if(Gate::denies('cms_conten_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cmsContenType->delete();

        return back();
    }

    public function massDestroy(MassDestroyCmsContenTypeRequest $request)
    {
        $cmsContenTypes = CmsContenType::find(request('ids'));

        foreach ($cmsContenTypes as $cmsContenType) {
            $cmsContenType->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
