@extends('admin.layouts.master')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection

@section('title')
    المستخدمين
@endsection

@section('content')
<!-- row opened -->
<div class="row row-sm">
    <!--div-->
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ trans('user.users') }}</h4>
                    <div class="btn btn-primary"><a class="text-white" href="{{ route('users.create') }}">{{ trans('user.add_new_user') }}</a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table key-buttons text-md-nowrap">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">{{ trans('dashboard.image') }}</th>
                                <th class="border-bottom-0">{{ trans('dashboard.name') }}</th>
                                <th class="border-bottom-0">{{ trans('user.email') }}</th>
                                <th class="border-bottom-0">{{ trans('user.phone') }}</th>
                                <th class="border-bottom-0">{{ trans('user.address') }}</th>
                                @canany(['view_user', 'edit_user', 'delete_user'])
                                    <th class="border-bottom-0">{{ trans('dashboard.actions') }}</th>
                                @endcanany
                                <th class="border-bottom-0">{{ trans('dashboard.created') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td><img width="50" height="50" src="{{ $user->img_path }}" alt="" srcset=""></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    @canany(['view_user', 'edit_user', 'delete_user'])
                                        <td class="row pl-3">
                                                @can('view_user')
                                                    <a href="{{ route('users.invoices', $user->id) }}" class="btn btn-info">{{ trans('dashboard.view_invoices') }}</a>
                                                @endcan
                                                &nbsp;&nbsp;
                                                @can('edit_user')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">{{ trans('dashboard.edit') }}</a>
                                                @endcan
                                            &nbsp;&nbsp;
                                                @can('delete_user')
                                                <form class="pl-3" action="{{ route('users.destroy', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">{{ trans('dashboard.delete') }}</button>
                                                </form>
                                                @endcan
                                        </td>
                                    @endcanany
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
@endsection

@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
