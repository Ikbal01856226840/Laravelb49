@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-10">
            <h1 class="h3 mb-2 text-gray-800">Expenditures</h1>
        </div>
        <div class="col-sm-2">
            <a class="btn btn-success" href="{{ url('/create_expense') }}">
                <i class="fa fa-plus" aria-hidden="true"></i> Expense
            </a>    
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Expenditures</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Expense</th>
                            <th class="text-center">User Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $k => $e)
                            <tr>
                                <td class="text-center">{{ $k+1 }}</td>
                                <td class="text-center">{{ $e->expenditures }}</td>
                                <td class="text-center">{{ $e->description }}</td>
                                <td class="text-center">{{ $e->date }}</td>
                                <td class="text-center">{{ $e->expense }}</td>
                                <td class="text-center">{{ $e->name }}</td>
                                <td class="text-center">
                                    <a href="{{ url('/edit_expense/'.$e->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="{{ url('/delete_expense/'.$e->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')"><i class="fas fa-trash"></i></a>
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