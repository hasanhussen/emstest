@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            اضافة صلاحيات ل{{$role->name}}
                        </p>
                      
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                        
                                     
                                            <th> الصلاحيات  </th>                      
                                       
                                          


                                        </tr>

                                    </thead>

                                    <tbody>
                                     
                                            <form action="{{route('givePermission',$role->id)}}" method="post" id="editFromData">
                    @csrf
                 @method('POST')
                               
                                        <tr>
                                            <td>
                               @foreach ($permissions as $permission)
                                        <input type="checkbox" name="permission" id="permission" value="{{ $permission->name }}">{{ $permission->name }}
                                        <br>
                                    @endforeach
                        
                              
                            

                                    </td>
                                        </tr>

                        <input type="submit" id="saveBtn" class="btn btn-primary" value="حفظ">
                </form>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
