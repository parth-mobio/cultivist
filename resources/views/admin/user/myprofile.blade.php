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
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  
                    <?php if ($edit->image != '') { ?>
                                        <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('/') }}uploads/admin/{{$edit->image}}" alt="User profile picture">
                    <?php } else { ?>
                        <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('/') }}uploads/admin/no_image.png" alt="User profile picture">
                                        
                            <?php } ?>   
                </div>

                <h3 class="profile-username text-center">{{$edit->name}}</h3>

                <p class="text-muted text-center">{{$edit->role}}</p>

                <!--<ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>-->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
          <!--  <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>-->
              <!-- /.card-header -->
          <!--    <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>-->
              <!-- /.card-body -->
           <!-- </div>-->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li><br>
                          @endforeach
                      </ul>
                  </div>
              @endif
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  
                  
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">User Detail</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <form method="POST" action="{{ URL::asset('users-edit/'.$edit->id) }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name *</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->name; ?>" id="name" class="form-control" name="name" placeholder="e.g Firstname Lastname" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email *</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->email; ?>" id="email" class="form-control" name="email" placeholder="e.g Email" required>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Phone  </label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->contact; ?>" id="phone" class="form-control" name="phone" placeholder="e.g Phone" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="image" class="form-control" placeholder="Please select image to upload">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">&nbsp;</label>
                        <div class="col-sm-10">
                          <?php if ($edit->image != '') { ?>
                                        <img src="{{ asset('/') }}uploads/admin/{{$edit->image}}" width="100px" height="100px" >
                                    <?php } else { ?>
                                        <img src="{{ asset('/') }}uploads/admin/no_image.png" width="100px" height="100px" >
                            <?php } ?>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Country</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->country; ?>" id="country" class="form-control" name="country" placeholder="e.g United State" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->city; ?>" id="city" class="form-control" name="city" placeholder="e.g Florida" required>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <textarea name="address" class="form-control"><?php echo $edit->address; ?></textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Zipcode</label>
                        <div class="col-sm-10">
                          <input type="text" value="<?php echo $edit->zipcode; ?>" id="zipcode" class="form-control" name="zipcode" placeholder="e.g 123456" required>
                        </div>
                      </div>

                      

                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Status*</label>
                        <div class="col-sm-10">
                          <select name="status" class="custom-select form-control" >
                                            <option value="">Select an option</option>
                                            <option value="0" <?php
                                            if ($edit->status = '0') {
                                                echo 'selected';
                                            }
                                            ?> >Disable</option>
                                            <option value="1" <?php
                                            if ($edit->status = '1') {
                                                echo 'selected';
                                            }
                                            ?> >Enable</option>

                            </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  

                  <div class="tab-pane" id="settings">
                    <form method="POST" action="{{URL::asset('update_password/'.Auth::user()->id)}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="inputSkills" class="col-sm-2 col-form-label">New Password  *</label>
                            <div class="col-sm-10">
                              <input type="Password"  id="pass" class="form-control" name="password" placeholder="e.g 123456">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputSkills" class="col-sm-2 col-form-label">Re-enter Password *</label>
                            <div class="col-sm-10">
                              <input type="Password"  id="pass" class="form-control" name="retype_password" placeholder="e.g 123456">
                            </div>
                        </div>

                        <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>

                    </form>   
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
</div>
@endsection
<script src="{{ asset('/') }}plugins/jquery/jquery.min.js"></script>
<?php $GetZone = URL::asset('getcity_zone'); ?>
<?php $GetCity = URL::asset('getstate_city'); ?>
<?php $GetState = URL::asset('getcountry_state'); ?>
<script type='text/javascript'>

$(document).ready(function () {

    $('#city').change(function () {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo $GetZone; ?>/' + id,
            type: 'get',
            dataType: 'html',
            success: function (response) {
                var len = 0;
                if (response != null) {
                    $("#zone").empty();
                    $("#zone").append(response);
                }
            }
        });
    });


    $('#state').change(function () {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo $GetCity; ?>/' + id,
            type: 'get',
            dataType: 'html',
            success: function (response) {
                var len = 0;
                if (response != null) {
                    $("#city").empty();
                    $("#city").append(response);
                }
            }
        });
    });

    $('#country').change(function () {
        var id = $(this).val();
        $.ajax({
            url: '<?php echo $GetState; ?>/' + id,
            type: 'get',
            dataType: 'html',
            success: function (response) {
                var len = 0;
                if (response != null) {
                    $(".state").empty();
                    $(".state").append(response);
                }
            }
        });
    });
});
</script>