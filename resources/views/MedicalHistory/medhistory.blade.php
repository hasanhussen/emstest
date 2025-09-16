@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                        المريض/ة:   {{$patient->name}}  {{$patient->fatherName}}  {{$patient->lastName}}
                        </p>
                  
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                            <th> اسم المريض </th>
                                            <th>  اسم المضيف  </th>
                                            <th> السابقة المرضية</th>
                                            <th> تاريخ الاضافة</th>
                                            <th>  وقت الاضافة</th>

                                       


                                        </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($medhistory as $med)
                                    <tr>
                                  

                                     
                                            <td>{{$med->patient->name}} </td>
                                            <td>{{$med->user->name}} </td>
                                            <td>{{$med->text}} </td>
                                            <td> {{$med->date}} </td>

                                            <td> {{$med->time}} </td>


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