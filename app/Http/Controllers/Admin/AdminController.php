<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Upload\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:add_admin'])->only(['create', 'store']);
        $this->middleware(['permission:edit_admin'])->only(['edit', 'update']);
        $this->middleware(['permission:view_admin'])->only(['index']);
        $this->middleware(['permission:delete_admin'])->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admins.index', ['admins' => Admin::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.add')->withRoles($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email|unique:admins,email', 'role' => 'required', 'password' => 'required|min:8|max:25' , 'main_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);

        if($validator->fails()){

            toastr()->error(trans('admin.errors'));

            return redirect()->back()->withInput()->withErrors($validator);
        }

        $request->merge(['password' => bcrypt($request->password), 'image' =>  Upload::uploadImage($request->main_image, 'admins' , $request->name)]);
        $admin = Admin::create($request->except('role','main_image'));
        $admin->assignRole($request->role);

        activity()->log('قام '.auth()->user()->name.'باضافة أدمن جديد'.$admin->name);

        toastr()->success(trans('admin.add_success'));

        return redirect()->route('admins.index');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', ['admin' => $admin, 'roles' => Role::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email|unique:admins,email,'.$admin->id.',id', 'role' => 'required' , 'main_image' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000']);

        if($request->password != null)
        {
            $validator = Validator::make($request->all(), ['password' => 'sometimes|min:8|max:25']);
        }

        if($validator->fails()){
            toastr()->error(trans('admin.errors'));

            return redirect()->back()->withErrors($validator);
        }

        if($request->password != null){
            $request->merge(['password' => bcrypt($request->password)]);
        }else{
            $request->merge(['password' => $admin->password]);
        }

        if ($request->has('main_image')) {

            Upload::deleteImage('admins', $admin->image);

            $request->merge(['image' =>  Upload::uploadImage($request->main_image, 'admins' , $request->name)]);
        }

        $admin->update($request->except('role','main_image'));
        $admin->syncRoles($request->role);

        activity()->log('قام '.auth()->user()->name.'بالتعديل على الأدمن'.$admin->name);

        toastr()->success(trans('admin.updated_success'));

        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Upload::deleteImage('admins', $admin->image);

        $admin->delete();

        activity()->log('قام '.auth()->user()->name.'بحذف الأدمن'.$admin->name);

        toastr()->success(trans('admin.deleted_success'));

        return redirect()->route('admins.index');

    }

}
