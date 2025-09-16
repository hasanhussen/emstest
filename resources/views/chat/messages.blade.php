@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            المحادثات
                        </p>
                       
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                            <th> #</th>
                                            <th>  المرسل  </th>
                                            <th>   الرسالة </th>
                                            <th>   نوع الرسالة </th>





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

            ajax: "{{ route('getmessages',$chat->id)}}",

         columns: [

    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    
    {data: 'user', name: 'user'},
    {data: 'message', name: 'message'},
    {data: 'type', name: 'type'},


  



                ]
      
        });
     


    });
</script>

@endpush