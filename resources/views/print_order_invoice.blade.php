<!DOCTYPE html>
<!-- This is My Awesome Template -->
<html>
    <head> 

        <style>
            div#container {
                text-align: center;
                font: normal 12px Arial, Helvetica, Sans-serif;
                background: white;
                padding: 20px;
            }

            table, td, th {
                border: 1px solid black;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
        </style>

    </head>
    <body>
        <!-- Main container with all invoice data -->
        <div id="container"> 
            <table>
                <tr>
                    <th>
                        <p><h3>{{ $user_info->shop_name != '' ? $user_info->shop_name : 'INVOICE' }}</h3></p>
                        <p><h3>Invoice No: {{ $order_summary->invoice_no }}</h3></p>
                       
                        @if($user_info->address != '')
                            <p>Address: {{ $user_info->address }}</p>
                        @endif
                        
                        <p>
                            @if($user_info->mobile != '')
                                Mobile: {{ $user_info->mobile.' , ' }}
                            @endif
                            @if($user_info->phone != '')
                                Phone: {{ $user_info->phone }}
                            @endif
                        </p>
                    </th>
                </tr>
            </table>
            <table style="margin-top: 5px;">
                <thead>
                    <tr style="font-size: 14px;">
                        <th>SL</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_list as $k => $v)
                        <tr style="font-size: 14px;">
                            <td>{{ $k+1 }}</td>
                            <td>{{ $v->product_name }}</td>
                            <td>{{ $v->quantity }}</td>
                            <td>{{ $v->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="font-size: 16px;">
                        <td colspan="3" align="right">Sub-Total</td>
                        <td>{{ $order_summary->total_amount }}</td>
                    </tr>
                    <tr style="font-size: 16px;">
                        <td colspan="3" align="right">Discount(%)</td>
                        <td>{{ $order_summary->discount_percentage }}</td>
                    </tr>
                    <tr style="font-size: 16px;">
                        <td colspan="3" align="right">VAT(%)</td>
                        <td>{{ $order_summary->vat_percentage }}</td>
                    </tr>
                    <tr style="font-size: 16px;">
                        <td colspan="3" align="right">GRAND TOTAL</td>
                        <td>{{ $order_summary->grand_total }}</td>
                    </tr>
                </tfoot>
            </table>
            <hr>
            <p>*** {{ ($user_info->receipt_note <> '' ? $user_info->receipt_note : 'Thank you for visiting us!') }} ***</p>
        </div>
    </body>
</html>