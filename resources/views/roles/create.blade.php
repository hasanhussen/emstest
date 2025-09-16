
@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                       
                    
                        <br>
            
<div  >
        <div >
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="title">انشاء دور  </label>
                
                    

                    </button>
                </div>
                <form action="{{ route('roles.store') }}" method="post" >
                @csrf
                @method('POST')
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6"> 
                            <label>  اسم الدور </label>
                               <div class="form-group">
                                   <input type="text" name="name" id="name" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>الصلاحية</label>
                               <div class="form-group">
                               @foreach($permission as $value)
                                {{ $value->name }}<input type="checkbox" name="permission[]"  value="{{$value->id}}">
                                @endforeach
                                <br>                                   <div id="img-list">

                                   </div>
                               </div><br>
                               
                                   </div>
                               </div><br>
                            


                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                        <input type="submit" id="saveBtn" class="btn btn-primary" value="حفظ">
                    </div>
                </form>
            </div>
        </div>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
