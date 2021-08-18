<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Cultivist</title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/') }}backend/dist/css/adminlte.min.css">

        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

        <link rel="stylesheet" href="{{ asset('/') }}backend/icons/lineawesome/css/line-awesome.css">

        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/fullcalendar/main.min.css">
        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/fullcalendar-daygrid/main.min.css">
        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/fullcalendar-timegrid/main.min.css">
        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/fullcalendar-bootstrap/main.min.css">

        <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/select2/css/select2.min.css" rel="stylesheet" />
         <link rel="stylesheet" href="{{ asset('/') }}backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        

        <!--        <link rel="stylesheet" href="http://cdn.ckeditor.com/4.14.1/full-all/contents.css">
                <link rel="stylesheet" href="https://ckeditor.com/docs/vendors/4.14.1/ckeditor/assets/css/classic.css">-->

        <script src="{{ asset('/') }}backend/plugins/jquery/jquery.min.js"></script>

        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <!--      <li class="nav-item d-none d-sm-inline-block">
                            <a href="index3.html" class="nav-link">Home</a>
                          </li>-->
                    <!--      <li class="nav-item d-none d-sm-inline-block">
                            <a href="#" class="nav-link">Contact</a>
                          </li>-->
                </ul>
                <ul class="navbar-nav ml-auto">

                </ul>
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="" class="brand-link">

                    <span class="brand-text font-weight-light"><b>Cultivist</b></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    @if(isset(Auth::user()->image))
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('/uploads/admin/'.Auth::user()->image) }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ Auth::user()->name }} </a>
                        </div>
                    </div>
                    @endif

                    @if(isset(Auth::user()->name))
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->

                            

                            <li class="nav-header">DASHBOARD</li>
                    <!--        <li class="nav-item has-treeview 

                                {{{ (Request::is('users-add') ? 'menu-open' : '') }}}
                                {{{ (Request::is('users-edit/*') ? 'menu-open' : '') }}}
                                {{{ (Request::is('users') ? 'menu-open' : '') }}}



                                ">
                                <a href="#" class="nav-link 


                                   {{{ (Request::is('users-add') ? 'active' : '') }}}
                                   {{{ (Request::is('users-edit/*') ? 'active' : '') }}}
                                   {{{ (Request::is('users') ? 'active' : '') }}}



                                   ">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Admin
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ URL::asset('users') }}" class="nav-link 
                                           {{{ (Request::is('users-add') ? 'active' : '') }}}
                                           {{{ (Request::is('users-edit/*') ? 'active' : '') }}}
                                           {{{ (Request::is('users') ? 'active' : '') }}}
                                           ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Admin</p>
                                        </a>
                                    </li>




                                </ul>
                            </li>-->
                            <li class="nav-item has-treeview 

                                {{{ (Request::is('my-profile/*') ? 'menu-open' : '') }}}
                                {{{ (Request::is('change_password/*') ? 'menu-open' : '') }}}



                                ">
                                <a href="#" class="nav-link 


                                   {{{ (Request::is('my-profile/*') ? 'active' : '') }}}
                                   {{{ (Request::is('change_password/*') ? 'active' : '') }}}

                                   



                                   ">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        My Account
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ URL::asset('my-profile/'.Auth::user()->id) }}" class="nav-link 
                                           
                                           {{{ (Request::is('my-profile') ? 'active' : '') }}}
                                           ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>My Profile</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ URL::asset('change_password/'.Auth::user()->id) }}" class="nav-link 
                                           
                                           {{{ (Request::is('change_password') ? 'active' : '') }}}
                                           ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Change Password</p>
                                        </a>
                                    </li>

                                </ul>
                            </li> 
                            
                            <li class="nav-item has-treeview 
                                {{{ (Request::is('customer-add') ? 'menu-open' : '') }}}
                                {{{ (Request::is('customer-edit/*') ? 'menu-open' : '') }}}
                                {{{ (Request::is('customer') ? 'menu-open' : '') }}}
                                ">
                                <a href="{{ URL::asset('customer') }}" class="nav-link 
                                   {{{ (Request::is('customer-add') ? 'active' : '') }}}
                                   {{{ (Request::is('customer-edit/*') ? 'active' : '') }}}
                                   {{{ (Request::is('customer') ? 'active' : '') }}}

                                   ">
                                    <i class="nav-icon fas fa-user-md"></i>
                                    <p>
                                        Customer 
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ URL::asset('customer') }}" class="nav-link 
                                           {{{ (Request::is('customer') ? 'active' : '') }}}
                                           ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>List</p>
                                        </a>
                                    </li>
                                <!--    <li class="nav-item">
                                        <a href="{{ URL::asset('customer-add') }}" class="nav-link 
                                           {{{ (Request::is('customer-add') ? 'active' : '') }}}
                                           ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Create</p>
                                        </a>
                                    </li>-->




                                </ul>
                            </li>
                            
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="{{ URL::asset('logout') }}" class="nav-link" onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                    <i class="nav-icon fas  fa-sign-out"></i>

                                    <p>
                                        Logout

                                    </p>

                                </a>     

                            </li>

                            <form id="logout-form"  method="POST" action="{{ URL::asset('logout') }}" style="display: none;">
                                {{csrf_field()}}
                                <button type="submit" class="btn  btn-success">Insert</button>
                            </form>



                        </ul>
                    </nav>
                    @endif
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>







            @yield('content')
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2020-2021 <a href="">Cultivist</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <!--<b>Version</b> 3.0.2-->
                </div>
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="{{ asset('/') }}backend/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('/') }}backend/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('/') }}backend/dist/js/adminlte.min.js"></script>
        <script src="{{ asset('/') }}backend/dist/js/demo.js"></script>
        <script src="{{ asset('/') }}backend/plugins/datatables/jquery.dataTables.js"></script>
        <script src="{{ asset('/') }}backend/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

        <!-- Bootstrap 4 -->
        <!--<script src="{{ asset('/') }}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>-->
        <!-- Select2 -->
        <script src="{{ asset('/') }}backend/plugins/select2/js/select2.full.min.js"></script>  
        <!-- overlayScrollbars -->
        <script src="{{ asset('/') }}backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/') }}backend/dist/js/adminlte.js"></script>
        <script src="{{ asset('/') }}backend/plugins/jquery-ui/jquery-ui.min.js"></script>
        <!-- OPTIONAL SCRIPTS -->
        
        <script src="{{ asset('/') }}backend/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="{{ asset('/') }}backend/plugins/raphael/raphael.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/jquery-mapael/jquery.mapael.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/jquery-mapael/maps/usa_states.min.js"></script>
        <!-- ChartJS -->
        <script src="{{ asset('/') }}backend/plugins/chart.js/Chart.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.14.1/standard-all/ckeditor.js"></script>
        <script src="{{ asset('/') }}backend/plugins/moment/moment.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/fullcalendar/main.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/fullcalendar-daygrid/main.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/fullcalendar-timegrid/main.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/fullcalendar-interaction/main.min.js"></script>
        <script src="{{ asset('/') }}backend/plugins/fullcalendar-bootstrap/main.min.js"></script>
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>-->
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


<!--        <script>
CKEDITOR.replace('description', {
    height: 260,
});
        </script>-->
        <script>
            $(function () {
                $("#example1").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "order": [[0,'desc' ]],
                });
            });
        </script>

<!--<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    

  })
</script>-->
@stack('custom-scripts')
        <!-- Page specific script -->
    <!--    <script>
                    $(function () {

                        /* initialize the external events
                         -----------------------------------------------------------------*/
                        function ini_events(ele) {
                            ele.each(function () {

                                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                                // it doesn't need to have a start or end
                                var eventObject = {
                                    title: $.trim($(this).text()) // use the element's text as the event title
                                }

                                // store the Event Object in the DOM element so we can get to it later
                                $(this).data('eventObject', eventObject)

                                // make the event draggable using jQuery UI
                                $(this).draggable({
                                    zIndex: 1070,
                                    revert: true, // will cause the event to go back to its
                                    revertDuration: 0  //  original position after the drag
                                })

                            })
                        }

                        ini_events($('#external-events div.external-event'))

                        /* initialize the calendar
                         -----------------------------------------------------------------*/
                        //Date for the calendar events (dummy data)
                        var date = new Date()
                        var d = date.getDate(),
                                m = date.getMonth(),
                                y = date.getFullYear()

                        var Calendar = FullCalendar.Calendar;
                        var Draggable = FullCalendarInteraction.Draggable;

                        var containerEl = document.getElementById('external-events');
                        var checkbox = document.getElementById('drop-remove');
                        var calendarEl = document.getElementById('calendar');

                        // initialize the external events
                        // -----------------------------------------------------------------

                        new Draggable(containerEl, {
                            itemSelector: '.external-event',
                            eventData: function (eventEl) {
                                console.log(eventEl);
                                return {
                                    title: eventEl.innerText,
                                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                                };
                            }
                        });

                        var calendar = new Calendar(calendarEl, {
                            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            //Random default events
                            events: [
                                {
                                    title: 'All Day Event',
                                    start: new Date(y, m, 1),
                                    backgroundColor: '#f56954', //red
                                    borderColor: '#f56954', //red
                                    allDay: true
                                },
                                {
                                    title: 'Long Event',
                                    start: new Date(y, m, d - 5),
                                    end: new Date(y, m, d - 2),
                                    backgroundColor: '#f39c12', //yellow
                                    borderColor: '#f39c12' //yellow
                                },
                                {
                                    title: 'Meeting',
                                    start: new Date(y, m, d, 10, 30),
                                    allDay: false,
                                    backgroundColor: '#0073b7', //Blue
                                    borderColor: '#0073b7' //Blue
                                },
                                {
                                    title: 'Lunch',
                                    start: new Date(y, m, d, 12, 0),
                                    end: new Date(y, m, d, 14, 0),
                                    allDay: false,
                                    backgroundColor: '#00c0ef', //Info (aqua)
                                    borderColor: '#00c0ef' //Info (aqua)
                                },
                                {
                                    title: 'Birthday Party',
                                    start: new Date(y, m, d + 1, 19, 0),
                                    end: new Date(y, m, d + 1, 22, 30),
                                    allDay: false,
                                    backgroundColor: '#00a65a', //Success (green)
                                    borderColor: '#00a65a' //Success (green)
                                },
                                {
                                    title: 'Click for Google',
                                    start: new Date(y, m, 28),
                                    end: new Date(y, m, 29),
                                    url: 'http://google.com/',
                                    backgroundColor: '#3c8dbc', //Primary (light-blue)
                                    borderColor: '#3c8dbc' //Primary (light-blue)
                                }
                            ],
                            editable: true,
                            droppable: true, // this allows things to be dropped onto the calendar !!!
                            drop: function (info) {
                                // is the "remove after drop" checkbox checked?
                                if (checkbox.checked) {
                                    // if so, remove the element from the "Draggable Events" list
                                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                                }
                            }
                        });

                        calendar.render();
                        // $('#calendar').fullCalendar()

                        /* ADDING EVENTS */
                        var currColor = '#3c8dbc' //Red by default
                        //Color chooser button
                        var colorChooser = $('#color-chooser-btn')
                        $('#color-chooser > li > a').click(function (e) {
                            e.preventDefault()
                            //Save color
                            currColor = $(this).css('color')
                            //Add color effect to button
                            $('#add-new-event').css({
                                'background-color': currColor,
                                'border-color': currColor
                            })
                        })
                        $('#add-new-event').click(function (e) {
                            e.preventDefault()
                            //Get value and make sure it is not null
                            var val = $('#new-event').val()
                            if (val.length == 0) {
                                return
                            }

                            //Create events
                            var event = $('<div />')
                            event.css({
                                'background-color': currColor,
                                'border-color': currColor,
                                'color': '#fff'
                            }).addClass('external-event')
                            event.html(val)
                            $('#external-events').prepend(event)

                            //Add draggable funtionality
                            ini_events(event)

                            //Remove event from text input
                            $('#new-event').val('')
                        })
                    })
        </script>-->

    </body>
</html>
