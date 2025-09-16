@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                       
                        <div class="row" style="margin: 20px;">
                                <a href="{{route('roles.index')}}" type="button" id="addClick" class="btn btn-primary"> الرجوع/{{$role->name}}</a>

                            </div>
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
                                    @foreach($rolePermissions as $Permissions)
<tr>
                             
                             <td> {{$Permissions->name}}  </td>

                       @endforeach
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
