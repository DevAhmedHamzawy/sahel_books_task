<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Upload\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:add_user'])->only(['create', 'store']);
        $this->middleware(['permission:edit_user'])->only(['edit', 'update']);
        $this->middleware(['permission:view_user'])->only(['index']);
        $this->middleware(['permission:delete_user'])->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$roles = Role::all();
        //return view('user.users.add')->withRoles($roles);
        return view('admin.users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email|unique:users,email', 'address' => 'required' , 'phone' => ['required','regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/']  ,'password' => 'required|min:6|max:25' , 'main_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000']);

        if($validator->fails()){

            toastr()->error(trans('users.errors'));

            return redirect()->back()->withInput()->withErrors($validator);
        }

        $request->merge(['password' => bcrypt($request->password), 'image' =>  Upload::uploadImage($request->main_image, 'users' , $request->name)]);
        $user = User::create($request->except('main_image'));

        activity()->log('قام '.auth()->user()->name.'باضافة مستخدم جديد'.$user->name);

        toastr()->success(trans('users.add_success'));

        return redirect()->route('users.index');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'email' => 'required|email|unique:users,email,'.$user->id.',id', 'address' => 'required' , 'phone' => ['required','regex:/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'] , 'main_image' => 'mimes:jpeg,jpg,png,gif|sometimes|max:10000']);

        if($request->password != null)
        {
            $validator = Validator::make($request->all(), ['password' => 'sometimes|min:6|max:25']);
        }

        if($validator->fails()){
            toastr()->error(trans('users.errors'));

            return redirect()->back()->withErrors($validator);
        }

        if($request->password != null){
            $request->merge(['password' => bcrypt($request->password)]);
        }else{
            $request->merge(['password' => $user->password]);
        }

        if ($request->has('main_image')) {

            Upload::deleteImage('users', $user->image);

            $request->merge(['image' =>  Upload::uploadImage($request->main_image, 'users' , $request->name)]);
        }

        $user->update($request->except('main_image'));

        activity()->log('قام '.auth()->user()->name.'بتعديل مستخدم'.$user->name);

        toastr()->success(trans('users.update_success'));

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Upload::deleteImage('users', $user->image);

        $user->delete();

        activity()->log('قام '.auth()->user()->name.'بحذف مستخدم'.$user->name);

        toastr()->success(trans('users.deleted_success'));

        return redirect()->route('users.index');
    }

}
