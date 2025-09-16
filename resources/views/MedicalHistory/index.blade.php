@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            المرضى
                        </p>
                       
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                            <th> #</th>
                                            <th> اسم المريض </th>
                                            <th> اسم الاب </th>
                                            <th> اسم الام </th>
                                            <th> اسم الجد </th>
                                            <th> اللقب </th>
                                            <th> تاريخ الميلاد</th>
                                            <th> الجنس </th>
                                            <th> رقم الهاتف </th>
                                            <th>  اقرب نقطة</th>
                                            <th>  المدينة</th>
                                            <th>  المنطقة</th>
                                      
                                         
                                            <th > العمليات </th>


                                        </tr>

                                    </thead>

                                    <tbody>

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
@push('pageJs')



<script type="text/javascript">
    $(function() {


        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });


        var table = $('#tableData').DataTable({
            "language": {
                "processing": " جاري المعالجة",
                "paginate": {
                    "first": "الأولى",
                    "last": "الأخيرة",
                    "next": "التالية",
                    "previous": "السابقة"
                },
                "search": "البحث :",
                "loadingRecords": "جاري التحميل...",
                "emptyTable": " لا توجد بيانات",
                "info": "من إظهار _START_ إلى _END_ من _TOTAL_ النتائج",
                "infoEmpty": "Showing 0 إلى 0 من 0 entries",
                "lengthMenu": "إظهار _MENU_ البيانات",
            },
            processing: true,

            serverSide: true,

            ajax: "{{ route('patientservices.index') }}",

         columns: [

    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    
    {data: 'name', name: 'name'},
    
    {data: 'fatherName', name: 'fatherName'},

    {data: 'motherName', name: 'motherName'},

    {data: 'gFatherName', name: 'gFatherName'},

    {data: 'lastName', name: 'lastName'},

    {data: 'birthday', name: 'birthday'},

    {data: 'gender', name: 'gender'},

    {data: 'phone', name: 'phone'},

    {data: 'address', name: 'address'},
  
    {data: 'city_id', name: 'city_id'},
    
    {data: 'region_id', name: 'region_id'},

  


                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },

                ]
      
        });
     
  
$(document).on('click', '.services', function(e) {
    e.preventDefault();
    var product_id = $(this).data("id");
    var url = "{{ route('medHistory', ':id') }}";
    url = url.replace(':id', product_id);
    window.location.href = url;
    
});

    });
</script>

@endpush