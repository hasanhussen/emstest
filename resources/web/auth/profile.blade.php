<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="{{asset('web_assets/image/x-icon" href="assets/images/favicon.png')}}">
    <link rel="stylesheet" href="https://fontawesome.com/icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


    <title>user profile</title>


<link rel="stylesheet" href="{{asset('web_assets/css/profilestyle.css')}}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- END: Custom CSS-->
</head>
<!-- END : Head-->

<!-- BEGIN : Body-->
<body >


<section class="vh-100" style="background-color: #FFFFFF; direction:rtl;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100"  style="width:120%;">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <img src="{{asset('storage/'.$user->avatar)}}"
                alt="Avatar" class="img-fluid my-5" style="width: 80px; border-radius: 100%;" />
              <h5>{{$user->name}}</h5>
              @if($user->gender==1)
              <p>Female</p>
              @elseif($user->gender==0)
              <p>Male</p>
              @endif
              <p>{{$user->birthday}}</p>


                <a class="btn btn-primary" href="{{route('userProfile.edit',$user->id)}}">  تعديل
                </a>
                <div class="d-flex justify-content-center my-3 ">
                  <a href="{{$user->instagram}}" class=" px-2">
                  <i class="fab fa-instagram " style="color: #FFFFFF;"></i>
                  </a>
                  <a href="{{$user->facebook}}">
                  <i class="fab fa-facebook" style="color: #FFFFFF;"></i>
                  </a>
                </div>
            </div>
            <div class="col-md-8">
              <div class="card-body p-4">
                <h6>معلومات شخصية</h6>

                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>الايميل</h6>
                    <p class="text-muted">{{$user->email}}</p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>الهاتف</h6>
                    <p class="text-muted">{{$user->phone}}</p>
                  </div>
                </div>
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>الطول</h6>
                    <p class="text-muted">{{$user->height}} cm</p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>الوزن</h6>
                    <p class="text-muted">{{$user->weight}} KG</p>
                  </div>
                </div>
                <h6>التقدم</h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>قبل</h6>
                    @if($user->before != null)
                    <img src="{{asset('storage/'.$user->before)}}"
                    alt="Avatar" class="img-fluid " style="width: 100px; " />
                    @endif
                  </div>
                  <div class="col-6 mb-3">
                    <h6>بعد</h6>
                    @if($user->after != null)
                    <img src="{{asset('storage/'.$user->after)}}"
                    alt="Avatar" class="img-fluid " style="width: 100px; " />
                    @endif
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<!-- END PAGE LEVEL JS-->
<!-- BEGIN: Custom CSS-->
<script src="{{asset('backend\assets\js\scripts.js')}}"></script>
<script src="{{asset('web_assets/js/inspect.js')}}"></script>


</body>

</html>
