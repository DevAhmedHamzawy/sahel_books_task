<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:add_role'])->only(['create', 'store']);
        $this->middleware(['permission:edit_role'])->only(['edit', 'update']);
        $this->middleware(['permission:view_role'])->only(['index']);
        $this->middleware(['permission:delete_role'])->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', ['roles' => Role::all()]);
    }

    public function create()
    {
        $permissions = Permission::get()->groupby('group_name');

        return view('admin.roles.add', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required|unique:roles,name', 'permissions' => 'required']);

        if($validator->fails()){
            toastr()->error(trans('roles.errors'));

            return redirect()->back()->withErrors($validator);
        }

        $role = Role::create($request->except('permissions'));

        if($request->has('permissions')){
            foreach($request->permissions as $permission){
                $role->givePermissionTo($permission);
            }
        }

        activity()->log('قام '.auth()->user()->name.'باضافة دور جديد '.$request->name);

        toastr()->success(trans('roles.add_success'));

        return redirect()->route('roles.index');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::get()->groupby('group_name');

        return view('admin.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        $validator = Validator::make($request->all(), ['name' => 'required|unique:roles,name,'.$role->id.',id', 'permissions' => 'required']);

        if($validator->fails()){
            toastr()->error(trans('roles.errors'));

            return redirect()->back()->withErrors($validator);
        }

        $role->update($request->all());

        if($request->has('permissions')){
            $role->syncPermissions($request->permissions);
        }

        activity()->log('قام '.auth()->user()->name.'بالتعديل على الدور '.$role->name);

        toastr()->success(trans('roles.updated_success'));

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $checkRole = Role::withCount('users')->find($role->id);

        if(!$checkRole->users_count){
            $role->delete();

            activity()->log('قام '.auth()->user()->name.'بحذف الدور '.$role->name);

            toastr()->success(trans('roles.deleted_success'));

            return redirect()->route('roles.index');
        }else{
            toastr()->error(trans('roles.deleted_failed'));

            return redirect()->route('roles.index');
        }
    }

}
