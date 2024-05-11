<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Create Expense</h1>
    

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
            <form action="{{ url('/save_expense') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="expenditures"
                            placeholder="Expenditures" required="required">
                            <span>* Expenditures</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="description" id="description"
                            placeholder="Description">
                            <span> Description</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="number" class="form-control form-control-user" name="expense" id="expense"
                            placeholder="Expense Amount" required="required">
                            <span>* Expense Amount</span>
                    </div>
                    <div class="col-sm-6">
                    <button class="btn btn-success">SAVE</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

</div>

    <script type="text/javascript">
    
        function checkEmailAddressAvailability(){
            var email = $("#email_address").val();

            if(email_address != ''){
                $.ajax({
                    type:'POST',
                    url:"{{ url('/user_availability') }}",
                    data:{"_token": "{{ csrf_token() }}", email: email},
                    success:function(data){
                        if(data.length > 0){
                            $("#email_emessage").css('display', 'block');
                            $("#email_address").val('');
                            $("#submit_btn").attr('disabled', 'disabled');
                        }else{
                            $("#email_emessage").css('display', 'none');
                            $("#submit_btn").attr('disabled', false);

                            $("#confirm_password").blur();
                        }
                    }
                });
            }
        }

    </script>

@endsection