
@extends("admin.layout")
@section('content')
<section id="input-style">
	<div class="row">
		<div class="col-12">
			<div class="card">

				<div class="card-content">
					<div class="card-body">
                    <h2 class="text-2xl font-semibold">الصلاحيات</h2>
                        <div class="pcoded-inner-content">
         <!-- Main-body start -->
         <div class="main-body">
             <div class="page-wrapper">
                 <!-- Page body start -->
                 <div class="page-body">
                     <div class="row">
                         <div class="col-sm-12">
                              <!-- Basic Form Inputs card start -->
                              <div class="card">
                                 <div class="card-block">
                              
                                 <form method="POST" action="{{ route('admin.permissions.store') }}">
                            @csrf
                          
                            <div class="form-body" style="direction: rtl;">
                          
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>الاسم</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control"
                                                id="name" name="name" >
                                                     <span class="text-danger error-text userName_error"></span>

                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    </div>

  

                                    <div class="col-6 d-flex justify-content-end " style="direction: ltr;" >
                                        <button type="submit" id="test-elementtest-element"
                                            class="btn btn-primary me-1 mb-1 test-element">اضافة</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                                 </div>
                             </div>
                             <script>
    $(document).on("click","#test-element",function() {
alert("click");
})
    </script>
    @endsection