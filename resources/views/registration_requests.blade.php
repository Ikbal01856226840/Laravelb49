@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users</h1>
    

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
                            <th class="text-center">Access Level</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registration_requests as $u)
                            <tr>
                                <td class="text-center">{{ $u->id }}</td>
                                <td class="text-center">{{ $u->name }}</td>
                                <td class="text-center">{{ $u->email }}</td>
                                <td class="text-center">{{ $u->access_level == 1 ? 'Admin' : ($u->access_level == 2 ? 'Sales Account' : 'Super Admin') }}</td>
                                <td class="text-center">{{ $u->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/edit_registration_request/'.$u->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
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