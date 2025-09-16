@extends("admin_layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                                الملف الشخصي
                            </p>

                            <form action="{{route('profile.update')}}" id="formData">
                                <div class="row">

                                    @csrf


                                    <div class="col-sm-3">
                                        <fieldset class="form-group">
                                            <label for="roundText">  الاسم  </label>
                                            <input type="text" id="name" name="name" class="form-control round" placeholder=" " value="{{$user->name}}">


                                        </fieldset>
                                    </div>

                                    <div class="col-sm-3">
                                        <fieldset class="form-group">
                                            <label for="roundText">  البريد الإلكتروني   </label>
                                            <input type="text" id="email" name="email" class="form-control round" placeholder=" " value="{{$user->email}}">


                                        </fieldset>
                                    </div>



                                    <div class="col-sm-3">
                                        <fieldset class="form-group">

                                            <label for="roundText">   كلمة السر   (في حال أردت تعديلها )</label>
                                            <input type="password" id="password" name="password" class="form-control round" placeholder="  ادخل  كلمة السر">
                                            <br>


                                        </fieldset>
                                    </div>

                                </div>
                            </form>
                       <div class="row">
                           <br>
                           <button type="button" id="saveBtn" class="btn gradient-purple-bliss">حفظ</button>
                       </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('myjs')


    <script type="text/javascript">

        $(function () {



            $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('<i class="fa fa-load"></i> ... ');
                $.ajax({

                    data: $("#formData").serialize(),

                    url: "{{ route('profile.update') }}",

                    type: "POST",

                    dataType: 'json',
                    timeout:4000,
                    success: function (data) {
                        $("#saveBtn").html('حفظ');
                     if(data.status==200){
                         Swal.fire({title:" تهانينا ",text:"تم الحفظ بنجاح",
                             type:"success",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});

                     }
                     else if(data.status==201){
                         Swal.fire({title:" تهانينا ",text:" البريد الالكتروني مستخدم سابقا",
                             type:"warning",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                     }
                     else{
                         Swal.fire({title:" تهانينا ",text:" يرجى المحاولة لاحقا",
                             type:"success",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});
                     }
                    window.location.reload();


                    },

                    error: function (data) {
                        $("#saveBtn").html('حفظ');

                        Swal.fire({title:" يا الهي ",text:" حدث خطأ ما - طول بالك اتوسة وحاول مرة اخرى    ",
                            type:"error",confirmButtonClass:"btn btn-primary",buttonsStyling:!1});

                    }

                });
            }); // end add new record




        });

    </script>

@endpush
