<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeStore;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:add_invoice'])->only(['create', 'store']);
        $this->middleware(['permission:edit_invoice'])->only(['edit', 'update']);
        $this->middleware(['permission:view_invoice'])->only(['index']);
        $this->middleware(['permission:delete_invoice'])->only(['delete']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.invoices.index', ['invoices' => Invoice::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.invoices.add',['users' => User::all(), 'exchange_stores' => ExchangeStore::all(), 'items' => Item::all() ,'units' => Unit::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!$request->has('subtotal') || $request->subtotal == 0){
            toastr()->error('برجاء اضافة منتجات');

            return redirect()->back();
        }

        $request->merge(['invoice_number' => 'INV-' . now()->format('YmdHis') . rand(100, 999)]);

        $invoice = Invoice::create($request->only('invoice_number', 'client_id', 'client_address', 'invoice_date', 'due_date' , 'subtotal', 'vat', 'total', 'notes'));

        for ($i=0; $i < count($request->product_ids) ; $i++) {

            $request->discount_sorts[$i] == 'نسبة' ? $specialChar = "%"  :  $specialChar = "ر.س" ;

            $discount_amount = str_replace($specialChar , '' , $request->discount_amounts[$i]);

            InvoiceItem::create([
             'invoice_id' => $invoice->id,
             'product_id' => $request->product_ids[$i],
             'product_price' => $request->unit_prices[$i],
             'qty' => $request->qtys[$i],
             'discount_sort' => $request->discount_sorts[$i],
             'discount' => $discount_amount,
             'sub_total' => $request->prices_after_discount[$i],
             'vat' => $request->vats_to_pay[$i],
             'total' => $request->total_prices[$i]
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $dataToEncode = [
            [1, $invoice->client->name],
            [2, 311221221221223],
            [3, $invoice->created_at],
            [4, $invoice->total],
            [5, $invoice->vat]
        ];

        $__TLV = $this->__getTLV($dataToEncode);
        $qr = base64_encode($__TLV);

        return view('admin.invoices.show', ['invoice' => $invoice, 'users' => User::all(), 'exchange_stores' => ExchangeStore::all(), 'items' => Item::all() ,'units' => Unit::all(), 'qr' => $qr]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', ['invoice' => $invoice, 'users' => User::all(), 'exchange_stores' => ExchangeStore::all(), 'items' => Item::all() ,'units' => Unit::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        if(!$request->product_ids){
            toastr()->error('برجاء اضافة منتجات');

            return redirect()->back();
        }

        $invoice->update($request->only('client_id', 'client_address', 'invoice_date', 'due_date' , 'subtotal', 'vat', 'total', 'notes'));

        $invoice->items()->delete();

        for ($i=0; $i < count($request->product_ids) ; $i++) {

            $request->discount_sorts[$i] == 'نسبة' ? $specialChar = "%"  :  $specialChar = "ر.س" ;

            $discount_amount = str_replace($specialChar , '' , $request->discount_amounts[$i]);

            InvoiceItem::create([
             'invoice_id' => $invoice->id,
             'product_id' => $request->product_ids[$i],
             'product_price' => $request->unit_prices[$i],
             'qty' => $request->qtys[$i],
             'discount_sort' => $request->discount_sorts[$i],
             'discount' => $discount_amount,
             'sub_total' => $request->prices_after_discount[$i],
             'vat' => $request->vats_to_pay[$i],
             'total' => $request->total_prices[$i]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        $invoice->items()->delete();

        toastr()->success(trans('invoice.deleted_success'));

        return redirect()->route('invoices.index');

    }

    public function downloadPdf(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
        ];

        $pdf = Pdf::loadView('admin.invoices.pdf', $data);

        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }

    function __getLength($value) {
        return strlen($value);
    }

    function __toHex($value) {
        return pack("H*", sprintf("%02X", $value));
    }

    function __string($__tag, $__value, $__length) {
        $value = (string) $__value;
        return $this->__toHex($__tag) . $this->__toHex($__length) . $value;
    }

    function __getTLV($dataToEncode) {
        $__TLVS = '';
        for ($i = 0; $i < count($dataToEncode); $i++) {
            $__tag = $dataToEncode[$i][0];
            $__value = $dataToEncode[$i][1];
            $__length = $this->__getLength($__value);
            $__TLVS .= $this->__string($__tag, $__value, $__length);
        }

        return $__TLVS;
    }
}
