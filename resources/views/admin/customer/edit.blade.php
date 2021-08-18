@extends('layouts.back_app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customer </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">customer List </li>
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
                                <h3 class="card-title"> View</h3>
                            </div>
                            <br><br>
                            
                            
                            <div class="form-group row d-flex align-items-center mb-5">
                                <?php $data_j = json_decode($edit->lead_response,true);
                                    // dd($data_j);   
                                ?>
                               <label class=""><?php 
                               echo "<pre>";
                               print_r($data_j) ; ?></label> 
                            </div>    
                            
                            
                            
                            <div class="form-group row d-flex align-items-center mb-5">
                                <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">&nbsp;</label>
                                <div class="col-lg-5">
                                    <div class="select">
                                        
                                        <a href="{{ URL::asset('customer') }}">
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
