@extends("admin.layout")
@section('content')
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="row">
            <div class="col-md-7"> 

            <p>اضافة نتائح للتحليل رقم: {{$tests->id}}/ المريض:{{$tests->Patients->name}} {{$tests->Patients->fatherName}} {{$tests->Patients->lastName}} </p>
            </div>
            <div class="col-md-2"> 

   <a href="{{route('testrequest.index')}}"id="addClick" class="btn btn-primary">رجوع</a>
   </div>


                            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" style="overflow-x:auto;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            @foreach($test as $t)

                <form action="{{route('addtestresult',$t->id)}}" method="post" id="editnoteData ">
                    @csrf

                  

                           <div class="row">
                           <div class="col-md-4"> 
              <p>    {{ $t->subclass->name }}:</p></div>
                  <div class="col-md-4"> 
 
                   <input type="text" class="form-control" id="note" name="value" value="{{ $t->value }}"></div>
                   <div class="col-md-2"> 

                   <input type="submit" id="savenote" class="btn btn-primary" value="حفظ"></div>

                     <br>
                               </div>
             
                </form>
                @endforeach

            </div>
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
