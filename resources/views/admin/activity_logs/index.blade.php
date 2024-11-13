@extends('admin.layouts.master')

@section('title')
Activity Logs
@endsection

@section('content')
<div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
        <div class="card-header pb-1">
            <h3 class="card-title mb-2">Activity Log</h3>
        </div>
        <div class="product-timeline card-body pt-2 mt-1">
            <ul class="timeline-1 mb-0">
                @foreach ($activityLogs as $log)
                <li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Log</span> <a href="#" class="float-right tx-11 text-muted">{{ $log->created_at->diffForHumans() }}</a>
                    <p class="mb-0 text-muted tx-12">{{ $log->description }}</p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection