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
                        <p><h3>Order List</h3></p>
                        <p><h3>Invoice No: {{ $invoice_no }}</h3></p>
                    </th>
                </tr>
            </table>
            <table style="margin-top: 5px;">
                <thead>
                    <tr style="font-size: 14px;">
                        <th>SL</th>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order_list as $k => $v)
                        <tr style="font-size: 14px;">
                            <td>{{ $k+1 }}</td>
                            <td>{{ $v->product_name }}</td>
                            <td>{{ $v->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <p>*** This copy is for cooking purpose! ***</p>
        </div>
    </body>
</html>