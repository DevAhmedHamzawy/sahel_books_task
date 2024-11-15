 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-body">

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">{{ trans('user.name') }}</p>
                    <input class="form-control" placeholder="{{ trans('user.name') }}" type="text" id="name">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">{{ trans('user.email') }}</p>
                    <input class="form-control" placeholder="{{ trans('user.email') }}" type="text" id="email">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">{{ trans('user.address') }}</p>
                    <input class="form-control" placeholder="{{ trans('user.address') }}" type="text" id="address">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">{{ trans('user.phone') }}</p>
                    <input class="form-control" placeholder="{{ trans('user.phone') }}" type="text" id="phone">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">{{ trans('user.password') }}</p>
                    <input class="form-control" placeholder="{{ trans('user.password') }}" type="text" id="password" value="{{ old('password') }}">
                </div>
            </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        <button type="button" onclick="saveClient()" class="btn btn-primary">حفظ</button>
        </div>
    </div>
    </div>
</div>
