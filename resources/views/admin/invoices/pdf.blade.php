<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->invoice_number }}</title>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('{{ storage_path("fonts/Cairo-Regular.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Cairo', sans-serif; /* تعيين الخط الجديد */
            text-align: right; /* محاذاة النص لليمين */
            direction: rtl; /* اتجاه النص من اليمين لليسار */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: right;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Invoice Number: {{ $invoice->invoice_number }}</h1>
    <p>Client Name : {{ $invoice->client->name }}</p>
    <p>Address: {{ $invoice->client_address }}</p>
    <p>Invoice Date: {{ $invoice->invoice_date }}</p>
    <p>Due Date : {{ $invoice->due_date }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Exchange Store</th>
                <th>Item</th>
                <th>Unit</th>
                <th>Product Price</th>
                <th>QTY</th>
                <th>Discount</th>
                <th>Sub Total</th>
                <th>VAT</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->exchange_store->name }}</td>
                    <td>{{ $item->product->item->name }}</td>
                    <td>{{ $item->product->unit->name }}</td>
                    <td>{{ $item->product_price }}</td>
                    <td>{{ $item->qty }}</td>

                    @php $item->discount_sort == 'نسبة' ? $specialChar = "%" : $specialChar = "ر.س" @endphp
                    <td>{{ $item->discount }}{{ $specialChar }}</td>


                    <td>{{ $item->sub_total }}</td>
                    <td>{{ $item->vat }}</td>
                    <td>{{ $item->total }}</td>



                </tr>
            @endforeach
            <tr class="total_data">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="width: 16%;"> Sub Total
                    <br><br>
                    VAT
                </td>
                <td></td>
                <td></td>
                <td>
                    <div id="subtotal">{{ $invoice->subtotal }}</div>
                <br>
                    <div id="tax">{{ $invoice->vat }}</div>
                </td>
            </tr>
            <tr class="total_data">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td></td>
            <td></td>
            <td><div id="total">{{ $invoice->total }}</td>
            </tr>
        </tbody>
    </table>

    <p>Total : {{ $invoice->total }}</p>
</body>
</html>
