@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                        العملاء المحظورين
                            </p>
                            <div class="row" style="margin: 20px;">
                                {{-- <button type="button" id="addClick" class="btn btn-primary">إضافة</button> --}}

                            </div>
                            <br>
                             <div class="row">

                                <div class="col-sm-12" style="overflow-x:auto;">
                                    <table id="tableData" class="table table-striped table-sm data-table">

                                        <thead>


                                        <tr>
                                            <th> #</th>
                                            <th>  اسم الزبون </th>
                                            <th> رقم الهاتف </th>
                                            <th> الايميل </th>
                                            <th> الجنس  </th>
                                            <th> سبب الحظر  </th>
                                            <th> العمليات </th>


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

        $(function () {


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

                ajax: "{{ url('ban_agents')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'email', name: 'phone_number'},
                    {data: 'sex', name: 'phone_number'},
                    {data: 'ban_info', name: 'stars'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

             });
    



             $('body').on('click', '.accept', function () {
                var agent_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "POST",
            url: "{{ url('accept_agent') }}/" + agent_id  ,
            data:{
                '_token':'{{csrf_token()}}'
            },
            success: function (data) {
             showSuccesFunction();
            table.draw(false);
            },
            error: function (data) { }
            });   }

            });

            }); // end delete row

 

        });

    </script>
@endpush

