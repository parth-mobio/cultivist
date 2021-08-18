@extends('layouts.back_app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Customer List</h1>
                    <div class="form-group row d-flex align-items-center mb-12">
                        <label class="col-lg-12 form-control-label d-flex justify-content-lg-end"></label>
                        <div class="col-lg-12">
                            @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                {{ Session::get('message') }}
                            </p>
                            @endif


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
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Customer List </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">  All Customer listing </h3>
                            <!-- <a href="{{ URL::asset('customer-add') }}">
                                
                                <button type="button" style="float: right;" class="btn btn-success">Add</button>
                                
                            </a>
                            <button type="button" style="float: right;margin-right: 20px;" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                                     Quick Add
                                 </button>-->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>First name</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Product Id</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Date</th>
                                        <th>Lead Id</th>
                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datas as $data) { ?>
                                        <tr>
                                            <td>{{$data->id}}</td>

                                            <td>{{$data->firstname}}</td>
                                            <td>{{$data->lastname}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>{{$data->phone_number}}</td>
                                            <td>{{$data->product_id}}</td>
                                            <td>{{$data->product_name}}</td>
                                            <td>{{$data->product_price}}</td>
                                            <td>{{date('m-d-Y H:i', strtotime($data->created_at))}}
                                            </td>
                                            <td>{{$data->leadId}}</td>
                                                                                                    

                                    <td>
                                <!--        <a href="#" status="<?php echo ($data->status == "1" ? "0" : "1" ); ?>" id="<?php echo $data->id; ?>" class="updateStatus">
                                            <i class="la updateIcon <?php echo ($data->status == "1" ? "la-eye" : "la-eye-slash" ); ?> edit" style="color:grey;font-size: 25px;"></i>
                                        </a>&nbsp;&nbsp;&nbsp;-->
                                        <a href="{{ URL::asset('customer-edit/'.$data->id) }}">
                                            <button type="button" class="btn btn-info">View</button>
                                        </a>
                                        <a data-href="{{ URL::asset('customer-remove/'.$data->id) }}" data-toggle="modal" data-target="#confirm-delete">
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </a>
                                    </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </section>
</div>

      <!-- /.modal -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete record?</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">close</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    Do you really want to delete this record?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>


<?php $Update_Url = URL::asset('customer-status-update'); ?>
<script type="text/javascript">
$(document).ready(function () {
    $('#confirm-delete').on('show.bs.modal', function (e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

    $(".updateStatus").click(function () {
        var id = $(this).attr("id");
        var status = $(this).attr("status");

        $.ajax({
            type: "post",
            url: "<?php echo $Update_Url; ?>",
            dataType: "json",
            data: {
                "id": id,
                "status": status,
                "_token": "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data.status) {
                    $("#" + id + " .updateIcon").removeClass('la-eye');
                    $("#" + id + " .updateIcon").removeClass('la-eye-slash');
                    if (status == "1") {
                        $("#" + id + " .updateIcon").addClass('la-eye');
                        $("#" + id).attr("status", "0");
                    } else {
                        $("#" + id + " .updateIcon").addClass('la-eye-slash');
                        $("#" + id).attr("status", "1");
                    }
                }
            }
        });
    });
});
</script>

@endsection
