 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">

        <div class="modal-body">

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">الاسم</p>
                    <input class="form-control" placeholder="الاسم" type="text" id="name">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">البريد الالكتروني</p>
                    <input class="form-control" placeholder="البريد الالكتروني" type="text" id="email">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">العنوان</p>
                    <input class="form-control" placeholder="العنوان" type="text" id="address">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">الهاتف</p>
                    <input class="form-control" placeholder="الهاتف" type="text" id="phone">
                </div>
            </div>

            <div class="col-md-12 mg-t-10 mg-md-t-0">
                <div class="form-group">
                    <p class="mg-b-10">كلمة المرور</p>
                    <input class="form-control" placeholder="كلمة المرور" type="text" id="password" value="{{ old('password') }}">
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
