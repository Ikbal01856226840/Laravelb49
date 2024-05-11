@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sale Product</h1>
    

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row mt-2 ml-2">
            <div class="col-sm-2">
                <button type="submit" class="btn btn-success btn-lg mt-2" onclick="saveSaleProduct()">SAVE ORDER</button>
            </div>
        </div>
        
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if(Session::has('flash_message'))
                    <p class="alert alert-danger">
                    {{ Session::get('flash_message') }}
                    </p>
                    {{ Session::forget('flash_message') }}
                @endif
                @if(Session::has('success_message'))
                    <p class="alert alert-success">
                    {{ Session::get('success_message') }}
                    </p>
                    {{ Session::forget('success_message') }}
                @endif

            </h6>
        </div>
        <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Sale Type <span style="color: red;">*</span></label>
                        <select class="form-control" id="sale_type" name="sale_type" required="required">
                            <option value="">Sale Type</option>
                            <option value="0">Restaurant</option>
                            <option value="1">Online</option>
                        </select>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Table </label>
                        <select class="form-control" id="table_no" name= table_no>
                            <option value="">Select Table</option>
                            @foreach($tables as $t)
                                <option value="{{ $t->id }}">{{ $t->table }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Customer Code 
                            <!-- <span class="btn btn-sm btn-warning" style="font-size: 0.6em;" title="Check"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                        </label>
                        <input class="form-control" name="customer_code" id="customer_code" />
                    </div>
                    <div class="col-sm-3 mb-3 mb-sm-0">
                        <label>Payment Type</label>
                        <select class="form-control" id="payment_type" name="payment_type">
                            <option value="">Payment Type</option>
                            <option value="0">Cash</option>
                            <option value="1">Mobile Banking</option>
                            <option value="2">Card</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <select class="form-control" name="item" id="item">
                            <option value="">Select Product</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id.'~'.$p->price }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="col-sm-2">
                        <span class="btn btn-sm btn-primary mt-2" title="Add Item" id="add_item">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </span>
                    </div> -->
                    <!-- <div class="col-sm-1"></div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success mt-2" onclick="saveSaleProduct()">SAVE ORDER</button>
                    </div> -->
                    
                </div>
                <div class="form-group row">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-data" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="3"><h5>Total</h5></th>
                                    <th class="text-center">
                                        <input type="text" class="form-control" autocomplete="off" readonly="readonly" name="total" id="total" />
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="3"><h5>Discount(%)</h5></th>
                                    <th class="text-center">
                                        <input type="text" class="form-control" autocomplete="off" name="discount" id="discount" value="0" onkeyup="calculateGrandTotal()" />
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="3"><h5>VAT(%)</h5></th>
                                    <th class="text-center">
                                    <input type="text" class="form-control" autocomplete="off" name="vat" id="vat" value="{{ auth()->user()->vat_percentage }}" onkeyup="calculateGrandTotal()" />
                                    </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="3"><h5>Grand Total</h5></th>
                                    <th class="text-center">
                                        <input type="text" class="form-control" autocomplete="off" readonly="readonly" name="grand_total" id="grand_total" />
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
        </div>
    </div>

</div>

<script type="text/javascript">

    $('select').select2();

    var prod_array = [];

    $('#item').on('change', function() {

        var item_value = $("#item").val();

        if(item_value != ''){

            var res = item_value.split('~');

            var prod_id = parseInt(res[0]);
            var prod_price = parseFloat(res[1]);
            var prod_name = $("#item option:selected").text();
            
            if(prod_array.indexOf(prod_id) == -1){
                
                prod_array.push(prod_id);

                $("#table-data tbody").append(
                    '<tr id="tr'+prod_id+'"><td class="text-center"><input type="text" class="form-control" readonly="readonly" name="product_name[]" id="product_name" value="'+prod_name+'" /><input type="hidden" class="form-control" readonly="readonly" name="product_id[]" id="product_id'+prod_id+'" value="'+prod_id+'" /></td><td class="text-center"><input type="text" class="form-control" readonly="readonly" name="product_price[]" id="product_price'+prod_id+'" value="'+prod_price+'" /></td><td class="text-center"><input type="text" class="form-control" autocomplete="off" name="quantity[]" id="quantity'+prod_id+'" onkeyup="calculateTotalPrice('+prod_id+');" /></td><td class="text-center"><input type="text" class="form-control total_price" readonly="readonly" name="total_price[]" id="total_price'+prod_id+'" value="" /></td><td class="text-center"><span class="btn btn-sm btn-danger" id="DeleteButton" title="Remove Item" onclick="deleteItem('+prod_id+');"><i class="fa fa-archive" aria-hidden="true"></i></span></td></tr>'
                );

            }else{
                alert("Item is Already Added!");
            }
        
        }

    });

    // $("#table-data").on("click", "#DeleteButton", function() {
    //     $(this).closest("tr").remove();

    //     calculateGrandTotal();
    // });

    function deleteItem(prod_id){
        $("#tr"+prod_id).remove();

        i = prod_array.indexOf(prod_id);
        if(i >= 0) {
            prod_array.splice(i,1);
        }

        calculateGrandTotal();
    }

    function calculateTotalPrice(prod_id){
        var product_price = $("#product_price"+prod_id).val();
        product_price = (product_price != '' ? product_price : 0);

        var qty = $("#quantity"+prod_id).val();
        qty = ((qty != '' && qty > -1) ? qty : 0);
        $("#quantity"+prod_id).val(qty);
        
        var total_price = product_price * qty;
        $("#total_price"+prod_id).val(total_price);
        
        calculateGrandTotal();
    }

    function calculateGrandTotal(){
        var sum = 0;
        $("input[class *= 'total_price']").each(function(){
            sum += +$(this).val();
        });
        $("#total").val(sum);

        var discount = $("#discount").val();
        discount = (discount != '' ? discount : 0);

        var vat = $("#vat").val();
        vat = (vat != '' ? vat : 0);

        var net_price = sum - parseFloat((((discount/100) * sum).toFixed(2)));
        net_price = (net_price != '' && !isNaN(net_price) && isFinite(net_price) ? net_price : 0);

        var vat_price = parseFloat(((vat/100) * net_price).toFixed(2));
        vat_price = (vat_price != '' && !isNaN(vat_price) && isFinite(vat_price) ? vat_price : 0);

        var grand_total = net_price+vat_price;
        grand_total = (grand_total != '' && !isNaN(grand_total) && isFinite(grand_total) ? grand_total : 0);

        console.log('Sub-Total: '+sum);
        console.log('Discounted Amount: '+net_price);
        console.log('Vat Price: '+vat_price);
        console.log('Grand-Total: '+grand_total);

        $("#grand_total").val(Math.round(grand_total));

    }

    function saveSaleProduct(){
        var sale_type = $("#sale_type").val();
        var table_no = $("#table_no").val();
        var customer_code = $("#customer_code").val();
        var payment_type = $("#payment_type").val();

        var total = $("#total").val();
        var discount = $("#discount").val();
        var vat = $("#vat").val();
        var grand_total = $("#grand_total").val();

        var product_ids = document.getElementsByName('product_id[]');

        var product_id_array = [];
        var product_qty_array = [];
        var product_price_array = [];

        for (var i = 0; i < product_ids.length; i++) {
            var prod_id = product_ids[i].value;

            var qty = $("#quantity"+prod_id).val();
            qty = (qty != '' ? qty : 0);

            var product_price = $("#product_price"+prod_id).val();
            product_price = (product_price != '' ? product_price : 0);

            if(qty > 0){
                product_id_array.push(prod_id);
                product_qty_array.push(qty);
                product_price_array.push(product_price);
            }
            
        } 
        
        if(sale_type != "" && product_id_array.length > 0){
            $.ajax({
                url: "{{ url('/save_sale_product') }}",
                type:'POST',
                data: {_token:"{{csrf_token()}}", total: total, discount: discount, vat: vat, grand_total: grand_total, sale_type: sale_type, table_no: table_no, customer_code: customer_code, payment_type: payment_type, product_id_array: product_id_array, product_qty_array: product_qty_array, product_price_array: product_price_array},
                dataType: "json",
                success: function (data) {
                    window.location.href = "{{URL::to('pending_sell_list')}}"
                }
            });
        }else{
            alert('Please Select All Required Fields!');
        }

    }
</script>

@endsection