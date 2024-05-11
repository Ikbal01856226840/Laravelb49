@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        @php 
            $allow_sub_accounts = auth()->user()->allow_sub_accounts; 
            $created_sales_accounts = sizeof($sales_accounts); 
        @endphp

        <div class="col-sm-10">
            <h1 class="h3 mb-2 text-gray-800">Sales Accounts</h1>
            <p
                @if($allow_sub_accounts ==  $created_sales_accounts) 
                    class="text-danger" 
                @else
                    class="text-success"
                @endif
            >Limit: {{ auth()->user()->allow_sub_accounts }}</p>
        </div>
        <div class="col-sm-2">
            <a class="btn btn-success" href="{{ url('/create_sales_account') }}" 
                @if($allow_sub_accounts ==  $created_sales_accounts) 
                    onclick="return false;" 
                @endif
                ><i class="fa fa-plus" aria-hidden="true"></i> Account</a>    
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Contact</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales_accounts as $k => $u)
                            <tr>
                                <td class="text-center">{{ $k+1 }}</td>
                                <td class="text-center">{{ $u->name }}</td>
                                <td class="text-center">{{ $u->email }}</td>
                                <td class="text-center">{{ $u->address }}</td>
                                <td class="text-center">{{ $u->mobile }}</td>
                                <td class="text-center">{{ $u->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/edit_sales_account/'.$u->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    
    function checkingLimit(){
        alert("You have reached your limit. Please contact with admin to increase your limit.");
        return false;
    }

</script>

@endsection