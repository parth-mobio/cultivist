@extends('layouts.back_app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admin </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin List </li>
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
                        <form method="POST" action="{{ URL::asset('users-edit/'.$edit->id) }}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="card-header">
                                <h3 class="card-title"> Edit</h3>
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
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Name *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->name; ?>" id="name" class="form-control" name="name" placeholder="e.g Firstname Lastname" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Email *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->email; ?>" id="email" class="form-control" name="email" placeholder="e.g Email" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Phone  *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->contact; ?>" id="phone" class="form-control" name="phone" placeholder="e.g Phone" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> Image </label>
                                <div class="col-lg-5">
                                    <input type="file" name="image" class="form-control" placeholder="Please select image to upload">
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end"> &nbsp;</label>
                                <div class="col-lg-5">
                                    <?php if ($edit->image != '') { ?>
                                        <img src="{{ asset('/') }}uploads/admin/{{$edit->image}}" width="100px" height="100px" >
                                    <?php } else { ?>
                                        <img src="{{ asset('/') }}uploads/site/noimage.jpg" width="100px" height="100px" >
                                    <?php } ?>
                                    <!--<img src="{{ URL::asset('uploads/users/'.$edit->image) }}" width="100px" height="100px">-->
                                </div>

                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Country  *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->country; ?>" id="country" class="form-control" name="country" placeholder="e.g United State" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">City  *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->city; ?>" id="city" class="form-control" name="city" placeholder="e.g Florida" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Address  *</label>
                                <div class="col-lg-5">
                                    <textarea name="address" class="form-control"><?php echo $edit->address; ?></textarea>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Zipcode  *</label>
                                <div class="col-lg-5">
                                    <input type="text" value="<?php echo $edit->zipcode; ?>" id="zipcode" class="form-control" name="zipcode" placeholder="e.g 123456" required>
                                    <div class="invalid-feedback">
                                        Please enter full name
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Role  *</label>
                                <div class="col-lg-5">
                                    <div class="select">
                                        <select name="role" class="custom-select form-control" required>
                                            <option value="">-- Select --</option>
                                            <option value="superadmin" <?php
                                            if ($edit->role == 'superadmin') {
                                                echo "selected";
                                            }
                                            ?>>Superadmin</option>
                                            <option value="admin" <?php
                                            if ($edit->role == 'admin') {
                                                echo "selected";
                                            }
                                            ?>>Admin</option>
                                            <option value="manager" <?php
                                            if ($edit->role == 'manager') {
                                                echo "selected";
                                            }
                                            ?>>Manager</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select an option
                                        </div>
                                    </div>
                                </div>
                            </div>




                             <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Status </label>
                                <div class="col-lg-5">
                                    <div class="select">
                                        <select name="status" class="custom-select form-control" >
                                            <option value="">Select an option</option>
                                            <option value="0" <?php
                                            if ($edit->status == '0') {
                                                echo "selected";
                                            }
                                            ?> >Disable</option>
                                            <option value="1" <?php
                                            if ($edit->status == '1') {
                                                echo "selected";
                                            }
                                            ?> >Enable</option>

                                        </select>
                                        <div class="invalid-feedback">
                                            Please select an option
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                <div class="col-lg-5">
                                    <div class="select">
                                        <button type="submit" class="btn  btn-success">Update</button>
                                        <a href="{{ URL::asset('users') }}">
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
