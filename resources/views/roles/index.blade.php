@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            الادوار
                        </p>
                        @can('اضافة دور')
                        <div class="row" style="margin: 20px;">
                                <a href="{{route('roles.create')}}" type="button" id="addClick" class="btn btn-primary">إضافة</a>

                            </div>
                            @endcan
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                     
                                            <th> الادوار  </th>                      
                                       
                                            <th> العمليات </th>


                                        </tr>

                                    </thead>

                                    <tbody>
                                    @foreach($roles as $role)
<tr>
                             
                             <td> {{$role->name}}  </td>
                                            <td>
<a href="{{ route('roles.show',$role->id) }}"  style="border-radius: 5px;"  class="btn btn-info btn-sm" ><i class="fa fa-info" aria-hidden="true" style="margin:3px;" > </i></a>


@can('تعديل دور')
<a href="{{ route('roles.edit',$role->id) }}"  style="border-radius: 5px;"  class="btn  btn-sm bg-primary" ><i class="icon-pencil" ></i></a>

<a href="{{ route('addPermission',$role->id) }}"  style="border-radius: 5px;"  class="btn  btn-sm bg-secondary" ><i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endcan


@can('حذف دور')

      <form action=" {{route('roles.destroy',$role->id)}}" method="post" style="display: inline-block;" >
                           @method('DELETE')
                           @csrf
<button type="submit" value="delete" style="border-radius: 5px;" class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>

                       </form>  
                       @endcan

</td>
                       </tr>
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
