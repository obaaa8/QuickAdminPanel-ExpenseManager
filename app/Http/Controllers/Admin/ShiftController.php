<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Shift;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShiftController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('shift_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shifts = Shift::all();

        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        abort_if(Gate::denies('shift_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('admin.shifts.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $shift = User::create($request->all());
        $shift->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.shifts.index');
    }

    public function edit(User $shift)
    {
        abort_if(Gate::denies('shift_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $shift->load('roles');

        return view('admin.shifts.edit', compact('roles', 'shift'));
    }

    public function update(UpdateUserRequest $request, User $shift)
    {
        $shift->update($request->all());
        $shift->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.shifts.index');
    }

    public function show(User $shift)
    {
        abort_if(Gate::denies('shift_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shift->load('roles');

        return view('admin.shifts.show', compact('shift'));
    }

    public function destroy(User $shift)
    {
        abort_if(Gate::denies('shift_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $shift->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
