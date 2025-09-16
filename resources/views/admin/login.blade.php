
<!DOCTYPE html>

<html class="loading" lang="en">
<!-- BEGIN : Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Apex admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Apex admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Now</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/img/alwadi.png')}}">
    <link rel="shortcut icon" type="image/jpg" href="{{asset('app-assets/img/alwadi.png')}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
{{--    <link href="{{asset('css.css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900')}}" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >    <!-- BEGIN VENDOR CSS-->
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\fonts\feather\style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\fonts\simple-line-icons\style.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\fonts\font-awesome\css\font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\perfect-scrollbar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\prism.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\switchery.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\select2.min.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN APEX CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\components.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\themes\layout-dark.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets\css-rtl\plugins\switchery.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\css-rtl\custom-rtl.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\datatables\dataTables.bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets\css\style-rtl.css')}}">--}}
    <link rel="stylesheet" href="{{asset('app-assets\vendors\css\dragula.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets\css-rtl\pages\ex-component-dragndrop.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets\css-rtl\pages\ex-component-sweet-alerts.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets\vendors\css\dropzone.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.0/mapbox-gl.js'></script>
    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<!-- BEGIN : Body-->
<body class="vertical-layout vertical-menu 2-columns  navbar-sticky" data-menu="vertical-menu" data-col="2-columns">




                <section id="login" class="auth-height" >
                    <div class="row full-height-vh m-0">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="card overflow-hidden">
                                <div class="card-content" >
                                    <div class="card-body auth-img">
                                        <div class="row m-0" >
                                            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center auth-img-bg p-3">
                                            <img src="{{asset('app-assets/img/alwadi.png')}}" alt="" class="img-fluid"  width="200" height="100">
                                            </div>



                                                <div class="col-lg-6 col-12 px-4 py-3 ">
                                                    <h4 class="mb-2 card-title ">Login </h4>
                                                    <p>  @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        @endif</p>
                                                    <form action="{{route('login')}}" method="post">
                                                        @csrf
                                                        @method('POST')
                                                    <input type="text" name="email"  class="form-control mb-3" placeholder="اسم المستخدم">
                                                    <input type="password" name="password" class="form-control mb-2" placeholder="كلمة السر">
                                                    <div class="d-sm-flex justify-content-between mb-3 font-small-2">
                                                        <div class="remember-me mb-2 mb-sm-0">
                                                            <div class="checkbox auth-checkbox">

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex justify-content-between flex-sm-row flex-column">

                                                        <button class="btn "style=" color:white; background-color: black;">دخول</button>
                                                    </div>
                                                    </form>

                                                </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Login Page Ends-->

        <!-- END : End Main Content-->



<!-- BEGIN VENDOR JS-->
<script src="{{asset('app-assets\vendors\js\vendors.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\vendors.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\switchery.min.js')}}"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN APEX JS-->
<script src="{{asset('app-assets\js\core\app-menu.min.js')}}"></script>
<script src="{{asset('app-assets\js\core\app.min.js')}}"></script>
<script src="{{asset('app-assets\js\notification-sidebar.min.js')}}"></script>
<script src="{{asset('app-assets\js\customizer.min.js')}}"></script>
<script src="{{asset('app-assets\js\scroll-top.min.js')}}"></script>
<script src="{{asset('app-assets\js\components-modal.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\datatable\jquery.dataTables.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\datatable\dataTables.bootstrap4.min.js')}}"></script>
<!-- END APEX JS-->
<!-- BEGIN PAGE LEVEL JS-->
{{--<script src="{{asset('app-assets\js\form-inputs.min.js')}}"></script>--}}

<script src="{{asset('app-assets\vendors\js\dragula.min.js')}}"></script>
<script src="{{asset('app-assets\js\ex-component-dragndrop.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\sweetalert2.all.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\dropzone.min.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\jscolor.js')}}"></script>
<script src="{{asset('app-assets\vendors\js\jscolor.min.js')}}"></script>
<script src="{{asset('app-assets\js\helpers.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>



<!-- END PAGE LEVEL JS-->
<!-- BEGIN: Custom CSS-->
<script src="{{asset('backend\assets\js\scripts.js')}}"></script>

</body>

</html>
