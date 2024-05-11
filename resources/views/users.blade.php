@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
        <h1 class="h3 mb-2 text-gray-800">Users</h1>
        </div>
        <div class="col-sm-2">
        <a class="btn btn-success" href="{{ url('/new_user') }}"><i class="fa fa-plus" aria-hidden="true"></i> User</a>
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
                            <th class="text-center">Mobile</th>
                            <th class="text-center">Sub-Account Limit</th>
                            <th class="text-center">Service Charge</th>
                            <th class="text-center">Valid Till</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr>
                                <td class="text-center">{{ $u->id }}</td>
                                <td class="text-center">{{ $u->name }}</td>
                                <td class="text-center">{{ $u->email }}</td>
                                <td class="text-center">{{ $u->mobile }}</td>
                                <td class="text-center">{{ $u->allow_sub_accounts }}</td>
                                <td class="text-center">{{ $u->service_charge }}</td>
                                <td class="text-center">{{ $u->account_valid_till }}</td>
                                <td class="text-center">{{ $u->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/edit_user/'.$u->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection