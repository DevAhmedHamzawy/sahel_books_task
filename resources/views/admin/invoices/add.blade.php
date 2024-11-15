@extends('admin.layouts.master')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <!-- row -->
    <div class="row" dir="rtl" style="font-family: 'Cairo', sans-serif !important">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        إضافة فاتورة جديدة
                    </div>
                    <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="pd-30 pd-sm-40 bg-gray-200">
                            <div class="row row-xs">


                                    <div class="col-lg-6">
                                        <div class="bg-gray-200">
                                            <div class="form-group">
                                                <p class="mg-b-10">إسم العميل</p>
                                                <select name="client_id" id="client_id" class="form-control">

                                                    <option value="">اختر الإسم ...</option>

                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach

                                                </select>

                                                <a class="btn btn-main-primary mt-2" href="javascript:void(0)"  data-toggle="modal" data-target="#exampleModal">اضافة عميل جديد</a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="bg-gray-200">
                                            <div class="form-group">
                                                <p class="mg-b-10">عنوان العميل</p>
                                                <input type="text" name="client_address" class="form-control" id="client_address" placeholder="عنوان العميل">
                                            </div>
                                        </div>
                                    </div>





                                    @include('admin.invoices.client_modal')






                            </div>

                            <div class="row row-xs mg-t-20">


                                <div class="col-lg-6">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <p class="mg-b-10">تاريخ الفاتورة</p>
                                            <input type="date" name="invoice_date" class="form-control" placeholder="تاريخ الفاتورة">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <p class="mg-b-10">تاريخ الاستحقاق</p>
                                            <input type="date" name="due_date" class="form-control" placeholder="تاريخ الاستحقاق">
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="row row-xs mg-t-20">

                                <div class="col-lg-2">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <select name="exchange_store_id" id="exchange_store_id" class="form-control">

                                                <option>مخزن الصرف<option>

                                                @foreach ($exchange_stores as $exchange_store)
                                                    <option value="{{ $exchange_store->id }}">{{ $exchange_store->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <select name="item_id" id="item_id" class="form-control">

                                                <option>السلعة</option>

                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <select name="unit_id" id="unit_id" class="form-control">

                                                <option>الوحدة</option>

                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <input id="qty" type="text" placeholder="الكمية" class="form-control" >
                                </div>

                                <div class="col-md-2">
                                    <input id="unit_price" type="text" placeholder="سعر الوحدة" class="form-control" id="input-disabled" disabled>
                                </div>

                                <div class="col-md-2">
                                    <input id="price" type="text" placeholder="السعر" class="form-control" id="input-disabled" disabled>
                                </div>

                            </div>

                            <div class="row row-xs">

                                <div class="col-lg-4">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <select name="discount_sort" onchange="getDiscountPercentage()" class="form-control" id="discount_sort">
                                                <option value="-1" selected disabled>نوع الخصم</option>
                                                <option value="0">نسبة</option>
                                                <option value="1">مبلغ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-4">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <select name="discount_amount" class="form-control" id="discount_amount">
                                                <option value="0" selected disabled>نسبة الخصم</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <input id="price_after_discount" type="text" placeholder="السعر بعد الخصم" class="form-control" id="input-disabled" disabled>
                                </div>


                            </div>


                            <div class="row row-xs">
                                <div onclick="addItem()" class="btn btn-primary col-md-10 mx-auto">اضافة</div>
                            </div>

                            <table class="table mt-4 mx-auto">
                                <thead style="background-color: #0099ff;color: #fff;">
                                  <tr>
                                    <th>#</th>
                                    <th>مخزن الصرف</th>
                                    <th>السلعه</th>
                                    <th>الوحده</th>
                                    <th>سعر الوحدة</th>
                                    <th>الكمية</th>
                                    <th>الخصم</th>
                                    <th>الإجمالى قبل الضريبة</th>
                                    <th>الضريبة</th>
                                    <th>الإجمالى</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>

                                  </tr>
                                  <tr class="total_data">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="width: 16%;">الاجمالى قبل الضريبة
                                        <br><br>
                                        قيمة الضريبة
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div id="subtotal"></div>
                                    <br>
                                        <div id="tax"></div>
                                    </td>
                                  </tr>
                                  <tr class="total_data">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>المجموع</td>
                                    <td></td>
                                    <td></td>
                                    <td><div id="total"></div></td>
                                  </tr>

                                </tbody>
                              </table>


                              <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea name="notes" placeholder="ملاحظات" class="form-control" id="" cols="30" rows="10"></textarea>

                                        @error('notes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row mb-0">
                                    <button type="submit" class="btn btn-primary col-md-12">
                                        إضافة طلب جديد
                                    </button>
                                </div>


                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-layouts.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>

    @include('admin.invoices.scripts')
@endsection
