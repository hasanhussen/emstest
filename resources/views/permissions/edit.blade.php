@extends("admin.layout")
@section('content')
<style>
    .btn-group-sm>.btn, .btn-sm {
    padding: 0rem 0rem !important;
    font-size: .875rem;
    line-height: 1.5;
    border-radius: 0.35rem;
}
</style>
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
                              
                                 <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-body" style="direction: rtl;">
                          
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>الاسم</label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-icon-left">
                                            <div class="position-relative">
                                                <input type="text" class="form-control"
                                                id="name" name="name" value="{{ $permission->name }}">
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
                                            class="btn btn-primary me-1 mb-1 test-element">تعديل</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                                 </div>
                             </div>
                             <div class="col-md-12">
                <div class="mt-8 p-2 bg-slate-100">
                    <h2 class="text-2xl font-semibold">الأدوار</h2>
                    <div class="flex space-x-2 mt-4 p-2">
                    @if ($permission->roles)
                            @foreach ($permission->roles as $permission_role)
                                <form class="btn btn-danger btn-sm" method="POST" data-original-title="Delete"  data-toggle="tooltip"  data-id="" 
                                    action="{{ route('admin.permissions.roles.remove', [$permission->id, $permission_role->id]) }}"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ $permission_role->name }}</button>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="max-w-xl mt-8">
                        <form method="POST" action="{{ route('admin.permissions.roles', $permission->id) }}">
                            @csrf
                           
                                <div class="col-md-12">
                                    <label>الأدوار</label>
                                </div>
                                <div class="col-md-5 mt-2">
                                    <div class="form-group has-icon-left">
                                        <div class="position-relative">
                                      
                                        <select id="role" name="role" autocomplete="role-name" class="form-control">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                        </select>
                                         <span class="text-danger error-text userName_error"></span>

                                            <div class="form-control-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                         
                    </div>
                    <div class="sm:col-span-6 pt-2">
                        <button type="submit"
                            class=" px-4 py-2 bg-green-500 hover:bg-green-700 rounded-md btn btn-primary me-1 mb-1">Assign</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).on("click","#test-element",function() {
alert("click");
})
    </script>
    @endsection