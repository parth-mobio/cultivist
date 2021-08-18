@extends('layouts.back_app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admin List</h1>
                    <div class="form-group row d-flex align-items-center mb-12">
                        <label class="col-lg-12 form-control-label d-flex justify-content-lg-end"></label>
                        <div class="col-lg-12">
                            @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">
                                {{ Session::get('message') }}
                            </p>
                            @endif
                        </div>
                    </div>
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



                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">  All Admin listing </h3>
                            <a href="{{ URL::asset('users-add') }}">
                                <button type="button" style="float: right;" class="btn btn-success">Add</button>
                            </a>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datas as $data) { ?>
                                        <tr>
                                            <td>{{$data->id}}</td>
                                            <td>
                                                <?php if ($data->image != '') { ?>
                                                    <img src="{{ asset('/') }}uploads/admin/{{$data->image}}" width="100px" height="100px" >
                                                <?php } else { ?>
                                                    <img src="{{ asset('/') }}uploads/site/noimage.jpg" width="100px" height="100px" >
                                                <?php } ?>


                                            </td>
                                            <td>{{$data->name}} 
                                                <br>
                                                <?php if ($data->role == 'superadmin') { ?>
                                                    <span data-toggle="tooltip" title="Disable" class="badge bg-info">SuperAdmin</span>
                                                <?php } ?>
                                                <?php if ($data->role == 'admin') { ?>
                                                    <span data-toggle="tooltip" title="Disable" class="badge bg-success">Admin</span>
                                                <?php } ?>
                                                <?php if ($data->role == 'manager') { ?>
                                                    <span data-toggle="tooltip" title="Disable" class="badge bg-danger">Manager</span>
                                                <?php } ?>
                                                


                                            </td>

                                            <td> {{$data->email}}                                               
                                            </td>
                                            <td> {{$data->contact}}                                               
                                            </td>



                                            <td>
                                                <a href="#" status="<?php echo ($data->status == "1" ? "0" : "1" ); ?>" id="<?php echo $data->id; ?>" class="updateStatus">
                                                    <i class="la updateIcon <?php echo ($data->status == "1" ? "la-eye" : "la-eye-slash" ); ?> edit" style="color:grey;font-size: 25px;"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="{{ URL::asset('users-edit/'.$data->id) }}">
                                                    <button type="button" class="btn btn-info">Edit</button>
                                                </a>
                                                <a data-href="{{ URL::asset('users-remove/'.$data->id) }}" data-toggle="modal" data-target="#confirm-delete">
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
<?php $Update_Url = URL::asset('user-status-update'); ?>
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
