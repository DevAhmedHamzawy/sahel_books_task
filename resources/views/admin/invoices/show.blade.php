@extends('admin.layouts.master')

@section('css')
    <!-- Internal Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ trans('invoice.show_invoice') }}
                    </div>
                    <form>
                        <div class="pd-30 pd-sm-40 bg-gray-200">
                            <div class="row row-xs">


                                    <div class="col-lg-6">
                                        <div class="bg-gray-200">
                                            <div class="form-group">
                                                <p class="mg-b-10">{{ trans('invoice.client_name') }}</p>
                                                <select name="client_id" id="client_id" class="form-control">

                                                    <option value="">اختر الإسم ...</option>

                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}" @if ($user->id == $invoice->client_id) selected @endif>{{ $user->name }}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="bg-gray-200">
                                            <div class="form-group">
                                                <p class="mg-b-10">{{ trans('invoice.client_address') }}</p>
                                                <input type="text" name="client_address" class="form-control" id="client_address" value="{{ $invoice->client_address }}" placeholder="عنوان العميل">
                                            </div>
                                        </div>
                                    </div>





                                    @include('admin.invoices.client_modal')





                                <div class="col-md mt-4 mt-xl-0">
                                    <button class="btn btn-main-primary btn-block">{{ trans('dashboard.add') }}</button>
                                </div>
                            </div>

                            <div class="row row-xs mg-t-20">


                                <div class="col-lg-6">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <p class="mg-b-10">{{ trans('invoice.invoice_date') }}</p>
                                            <input type="date" name="invoice_date" value="{{ $invoice->invoice_date }}" class="form-control" placeholder="تاريخ الفاتورة">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="bg-gray-200">
                                        <div class="form-group">
                                            <p class="mg-b-10">{{ trans('invoice.due_date') }}</p>
                                            <input type="date" name="due_date" value="{{ $invoice->due_date }}" class="form-control" placeholder="تاريخ الاستحقاق">
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
                                    <th>الصنف</th>
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
                                    @foreach ($invoice->items as $item)
                                        @php $n = rand(0,333)  @endphp
                                        <tr id="r{{ $n }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->product->exchange_store->name }}</td>
                                            <td>{{ $item->product->item->name }}</td>
                                            <td>{{ $item->product->unit->name }}</td>
                                            <td>{{ $item->product_price }}</td>
                                            <td>{{ $item->qty }}</td>

                                            @php $item->discount_sort == 'نسبة' ? $specialChar = "%" : $specialChar = "ر.س" @endphp
                                            <td>{{ $item->discount }}{{ $specialChar }}</td>


                                            <td class="prices_after_discount" id="price_after_discount_{{ $n }}">{{ $item->sub_total }}</td>
                                            <td class="vat_values" id="vat_value_{{ $n }}">{{ $item->vat }}</td>
                                            <td class="total_prices" id="total_price_{{ $n }}">{{ $item->total }}</td>

                                            <input type="hidden" name="unit_prices[]" id="unit_price_{{ $n }}" value="{{ $item->product_price }}" >
                                            <input type="hidden" name="discount_sorts[]" id="discount_sort_{{ $n }}"  value="{{ $item->discount_sort }}" >
                                            <input type="hidden" name="discount_amounts[]" id="discount_amount_{{ $n }}"  value="{{ $item->discount }}" >
                                            <input type="hidden" name="prices_after_discount[]" id="price_after_discount_{{ $n }}"  value="{{ $item->sub_total }}" >
                                            <input type="hidden" name="qtys[]" id="qty_{{ $n }}"  value="{{ $item->qty }}" >

                                            <input type="hidden" name="product_ids[]" id="product_id_{{ $n }}" value="{{ $item->product->id }}" >

                                            <input type="hidden" name="vats_to_pay[]" id="vat_to_pay_{{ $n }}" value="{{ $item->vat }}" >
                                            <input type="hidden" name="total_prices[]" id="total_price_{{ $n }}" value="{{ $item->total }}" >

                                        </tr>
                                    @endforeach
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
                                        <div id="subtotal">{{ $invoice->subtotal }} <input type="hidden" name="subtotal" value="{{ $invoice->subtotal }}" ></div>
                                    <br>
                                        <div id="tax">{{ $invoice->vat }} <input type="hidden" name="vat" value="{{ $invoice->vat }}" ></div>
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
                                    <td><div id="total">{{ $invoice->total }} <input type="hidden" name="total" value="{{ $invoice->total }}" ></div></td>
                                  </tr>

                                </tbody>
                              </table>


                              <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea name="notes" placeholder="ملاحظات" class="form-control" id="" cols="30" rows="10">{{ $invoice->notes }}</textarea>

                                        @error('notes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row row-xs justify-content-center">
                                    {!! QrCode::generate($qr); !!}
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

@endsection
