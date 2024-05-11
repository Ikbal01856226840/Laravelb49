@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Reconcile Order</h1>
    

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
            <form action="{{ url('/allow_reconciliation') }}" method="POST">
                {{ csrf_field() }} 
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select class="form-control" name="invoice_id" id="invoice_id" required="required">
                            <option value="">Invoice No / Amount</option>
                            @foreach($invoice_nos as $i)
                                <option value="{{ $i->id }}">{{ $i->invoice_no.' / '.$i->grand_total }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success">Allow</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>

</div>

    <script type="text/javascript">
        $('select').select2();
    </script>

@endsection