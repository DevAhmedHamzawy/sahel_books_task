
<script>

    function saveClient () {


    let name = $('#name').val(),
    email = $('#email').val(),
    phone = $('#phone').val(),
    address = $('#address').val(),
    password = $('#password').val();

    let body = {
        name: name,
        email: email,
        phone: phone,
        address: address,
        password: password
    }

axios.post('{{ route('users.store') }}', body , {headers: {'X-Requested-With': 'XMLHttpRequest'}})
    .then((response) => {
        console.log(response);



         alert(response.data.message);

        const lastUser = response.data.user;

        $('#client_id').append('<option value="'+lastUser.id+'">'+lastUser.name+'</option>');

        $('#exampleModal').hide();
        $('.modal-backdrop').remove();

        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid');
    })
    .catch((error) => {
        if (error.response && error.response.status === 422) {
            let errors = error.response.data.errors;

            Object.keys(errors).forEach(function (field) {
                let input = $(`[id="${field}"]`);

                input.addClass('is-invalid');


                input.after(`<span class="invalid-feedback" role="alert"><strong>${errors[field][0]}</strong></span>`);
            });
        } else {
            console.error(error);
        }
    });

}


$(document).on('change', '#exchange_store_id,#item_id,#unit_id', function(){
        getProduct();
    })


    $(document).on('keyup', '#qty', function(){
        calculateTotalPrice()
    })

    $(document).on('change', '#discount_amount', function(){
        calculateTotalPrice()
    })

$('#client_id').on('change', function() {

    axios.get('{{ url('admin/get_address') }}/' + $(this).val())
    .then((response) => {
       $('#client_address').val(response.data);
    })
    .catch((error) => {
        console.error(error);
    });

});

function calculateTotalPrice(){

let exchange_store_id_ = $('#exchange_store_id').val(),
    item_id_ = $('#item_id').val(),
    unit_id_ = $('#unit_id').val(),
    qty_ = $('#qty').val(),
    price_ = $('#unit_price').val()
    exchange_store_id = Number(exchange_store_id_),
    item_id = Number(item_id_),
    unit_id = Number(unit_id_),
    qty = Number(qty_),
    price = Number(price_);

if(price > 0 && exchange_store_id > 0 && item_id > 0 && unit_id > 0) {
    var total = price * qty;
    var discount_sort = $('#discount_sort :selected').val();
    var discount_amount = $('#discount_amount :selected').val();

    $('#price').val(total);

    discount_sort = Number(discount_sort)
    if(isNaN(discount_amount) || discount_amount == undefined){
        discount_amount = 0;
    }
    discount_amount = Number(discount_amount)

    console.log({discount_sort, discount_amount})

    if(discount_sort == 0) // نسبة
    {
        discount_amount = discount_amount / 100 * total;
    }
    total -= discount_amount;

    $('#price_after_discount').val(total);
}
}


function getProduct() {
        let exchange_store_id_ = $('#exchange_store_id').val(),
            item_id_ = $('#item_id').val(),
            unit_id_ = $('#unit_id').val(),
            qty = $('#qty').val(),
            exchange_store_id = Number(exchange_store_id_),
            item_id = Number(item_id_),
            unit_id = Number(unit_id_),
            url = '{{ url('admin/get_product_data') }}',
            body = {exchange_store_id, item_id, unit_id, qty};

        if(exchange_store_id > 0 && item_id > 0 && unit_id > 0){
            axios.get(url, { params:body })
                .then((data) => {

                    if (data.data == false) {
                        alert('لا يوجد .... الرجاء اضافة المنتج فى صفحة تسعير المنتجات');
                        return;
                    }

                    $('#price').empty();
                    $('#price').val(data.data.price_qty)
                    $('#unit_price').empty();
                    $('#unit_price').val(data.data.price)

                    calculateTotalPrice()

                })
        }

}


function getDiscountPercentage() {
        let discount_sort = $('#discount_sort').val();


        axios.get('{{ url('admin/get_discount_amounts') }}' + '/' + discount_sort)
            .then((data) => {

                if (data.data == false) {
                    alert('لا يوجد ..... الرجاء اضافة الخصم فى صفحة الخصومات');
                    return;
                }

                $('#discount_amount').empty();
                $('#discount_amount').append('<option value="0">نسبة الخصم</option>')
                for (d of data.data) {
                    $('#discount_amount').append('<option value="'+ d.amount +'">' + d.amount + '</option>')
                }

                calculateTotalPrice()
            })
}

// index for table
var index = 0;

function addItem() {

    if($('#exchange_store_id :selected').val() == 'مخزن الصرف') { alert('برجاء اختيار المخزن'); return;  }
    if($('#item_id :selected').val() == 'السلعة') { alert('برجاء اختيار السلعة'); return;  }
    if($('#unit_id :selected').val() == 'الوحدة') { alert('برجاء اختيار الوحدة'); return;  }

    // increment index for table
    index++;

    var exchange_store_id = $('#exchange_store_id :selected').val();
    var item_id = $('#item_id :selected').val();
    var unit_id = $('#unit_id :selected').val();
    var unit_price = $('#unit_price').val();
    var qty = $('#qty').val();
    var discount_sort = $('#discount_sort :selected').text();
    var discount_amount = $('#discount_amount :selected').text();
    var price_after_discount = $('#price_after_discount').val();
    url = '{{ url('admin/get_product_data') }}',
    body = {exchange_store_id, item_id, unit_id, qty};

    // check if this no discount then assign price_after_discount to regular price
    if ($('#discount_amount :selected').val() == 0) discount_amount = 0
    if (price_after_discount == '') price_after_discount = $('#price').val()

    // check discount_sort
    discount_sort == 'نسبة' ? discount_amount += "%" : discount_amount += "ر.س"


    $('.table tbody').append('<input type="hidden" name="unit_prices[]" id="unit_price_' + index + '" value="' + unit_price + '" >');
    $('.table tbody').append('<input type="hidden" name="discount_sorts[]" id="discount_sort_' + index + '" value="' + discount_sort + '" >');
    $('.table tbody').append('<input type="hidden" name="discount_amounts[]" id="discount_amount_' + index + '" value="' + discount_amount + '" >');
    $('.table tbody').append('<input type="hidden" name="prices_after_discount[]" id="price_after_discount_' + index + '"  value="' + price_after_discount + '" >');
    $('.table tbody').append('<input type="hidden" name="qtys[]" id="qty_' + index + '"  value="' + qty + '" >');

    axios.get(url, { params:body })
    .then((data) => {

        $('.table tbody').append('<input type="hidden" name="product_ids[]" id="product_id_' + index + '" value="' + data.data.id + '" >');


        // set vat to "2.5" by default
        var vatToPay = parseFloat((price_after_discount / 100) * 2.5).toPrecision(5);
        var totalPrice = parseFloat(price_after_discount) + parseFloat(vatToPay);
        $('.table tbody').append('<input type="hidden" name="vats_to_pay[]" id="vat_to_pay_' + index + '" value="' + vatToPay + '" >');
        $('.table tbody').append('<input type="hidden" name="total_prices[]" id="total_price_' + index + '" value="' + totalPrice + '" >');

        $('.table tbody').prepend('<tr id="r' + index + '"><td>1</td><td>' + data.data.exchange_store.name + '</td><td>' + data.data.item.name + '</td><td>' + data.data.unit.name + '</td><td>' + unit_price + '</td><td>' + qty + '</td><td>' + discount_amount + '</td><td class="prices_after_discount" id="price_after_discount_' + index + '">' + price_after_discount + '</td><td class="vat_values" id="vat_value_' + index + '">' + vatToPay + '</td><td class="total_prices" id="total_price_' + index + '">' + totalPrice + '<div class="btn btn-danger" onclick="delete_item(' + index + ')">حذف</div></td></tr>')

        // add index number to items
        $(".table tr").each(function () {
            $(this).find("td").first().html($(this).index() + 1);
        });
        $('.total_data').each(function () {
            $(this).find("td").first().html('');
        });

        getPricesAfterDiscount();

        getVatValues();

        getTotalPrices();
    })

    $('#exchange_store_id').val('مخزن الصرف');
    $('#item_id').val('السلعة');
    $('#unit_id').val('الوحدة');
    $('#qty').val('');
    $('#price').val('');
    $('#unit_price').val('');
    $('#discount_sort').val(-1);
    $('#discount_amount').val(0);
    $('#price_after_discount').val('');


}


function delete_item(item) {
    var price_after_discount = $('#price_after_discount_' + item).text();
    var vat_value = $('#vat_value_' + item).text();
    var total_price = parseFloat($('#total_price_' + item).text())

    $('#subtotal').text($('#subtotal').text() - price_after_discount);
    $('#tax').text($('#tax').text() - vat_value);
    $('#total').text($('#total').text() - total_price);

    $('.table tbody').append('<input type="hidden" name="subtotal" value="' + $('#subtotal').text() + '" >');
    $('.table tbody').append('<input type="hidden" name="vat" value="' + $('#tax').text() + '" >');
    $('.table tbody').append('<input type="hidden" name="total" value="' + $('#total').text() + '" >');


    $('#r' + item).remove();
    $('#unit_price_' + item).remove();
    $('#discount_sort_' + item).remove();
    $('#discount_amount_' + item).remove();
    $('#price_after_discount_' + item).remove();
    $('#qty_' + item).remove()
    $('#product_id_' + item).remove()
    $('#vat_to_pay_' + item).remove()
    $('#total_price_' + item).remove()
}


// Get Prices After Discount
function getPricesAfterDiscount() {
    // prices after discount
    var sum = 0;
    $('.prices_after_discount').each(function () {
        sum += parseFloat($(this).text());
    });

    $('#subtotal').text(sum);
    $('.table tbody').append('<input type="hidden" name="subtotal" value="' + sum + '" >');
}


// Get Vat Values
function getVatValues() {
    // vat values
    var sum = 0;
    $('.vat_values').each(function () {
        sum += parseFloat($(this).text());
    });

    $('#tax').text(sum);
    $('.table tbody').append('<input type="hidden" name="vat" value="' + sum + '" >');
}


// Get Total Prices
function getTotalPrices() {
    // total prices
    var sum = 0;
    $('.total_prices').each(function () {
        sum += parseFloat($(this).text());
    });

    $('#total').text(sum);
    $('.table tbody').append('<input type="hidden" name="total" value="' + sum + '" >');
}



</script>
