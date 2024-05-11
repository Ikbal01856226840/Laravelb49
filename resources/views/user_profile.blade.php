<?php use Illuminate\Support\Facades\Session; ?>

@extends('master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Profile</h1>
    

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
            <form action="{{ url('/update_user_profile/'.$user_info->id) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control form-control-user" name="name"
                            value="{{ $user_info->name }}" placeholder="User Name" required="required">
                        <span>* User Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control form-control-user" name="email" readonly="readonly"
                            value="{{ $user_info->email }}" placeholder="Email Address" required="required">
                        <span>* Email</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="shop_name"
                            value="{{ $user_info->shop_name }}" placeholder="Shop Name" required="required">
                        <span>* Shop Name</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="address"
                            value="{{ $user_info->address }}" placeholder="Address" required="required">
                        <span>* Shop Address</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="phone"
                            value="{{ $user_info->phone }}" placeholder="Phone No">
                        <span> Phone</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="mobile"
                            value="{{ $user_info->mobile }}" placeholder="Mobile No" required="required">
                        <span>* Mobile</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="receipt_note"
                            value="{{ $user_info->receipt_note }}" placeholder="Receipt Note">
                        <span> Receipt Note</span>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control form-control-user" name="service_charge"
                            value="{{ $user_info->service_charge }}" placeholder="Service Charge"
                            readonly="readonly">
                        <span> Service Charge</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                    <input type="number" class="form-control" id="vat_percentage" name="vat_percentage" value="{{ $user_info->vat_percentage }}" required="required" placeholder="Enter VAT percentage" />
                        <span> * VAT Percentage</span>
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection