@extends('layouts.back_app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Change Password </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My-profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">



                    <div class="card card-success">
                        <form method="POST" action="{{ URL::asset('update_password/'.$id) }}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="card-header">
                                <h3 class="card-title">Edit</h3>
                            </div>
                            <br><br>


                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                <div class="col-lg-5">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li><br>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Password *</label>
                                <div class="col-lg-5">
                                    <input type="password" value="" id="pass" class="form-control" name="password" placeholder="enter password" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Re-type Password *</label>
                                <div class="col-lg-5">
                                    <input type="password" value="" id="pass" class="form-control" name="retype_password" placeholder="enter password" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                <div class="col-lg-5">
                                    <div class="select">
                                        <button type="submit" class="btn  btn-success">Update</button>
                                        <a href="{{ URL::asset('home') }}">
                                            <button type="button" class="btn btn-danger">Back</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>        
        </div>
    </section>
</div>
@endsection
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
