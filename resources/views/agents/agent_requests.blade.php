@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                        طلبات العملاء
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


    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">   حظر العميل   </label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
                        <form action="#" method="post" id="editFromData" >
                            @csrf
                            <input type="hidden" name="_id" id="_id">
                            <div class="modal-body">
                                <div class="row">
                                   
                                        <div class="col-md-10">
                                         <label> سبب الحظر </label>
                                        <div class="form-group">
                                            <textarea rows="6" cols="50" class="form-control" name="ban_info" id="ban_info"></textarea>
        
                                        </div>
        
                                    </div>
                                 
                                </div>
        
        
                            </div>
                            <div class="modal-footer">
                                <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                                <input type="submit" name="ban" id="ban" class="btn btn-primary ban" value="حظر">
        
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

                ajax: "{{ route('agent_requests')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'email', name: 'phone_number'},
                    {data: 'sex', name: 'phone_number'},
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

            }); // end accept row


            $('body').on('click', '.banInfo', function () {
               
               var product_id = $(this).data('id');
               $("#title").html("حظر العميل ");
               $.get("{{ route('agents.index') }}" + '/' + product_id + '/edit', function (data) {
                   $("#saveBtn").val("حظر");
                   $('#_id').val(data.id);
                   $('#ban_info').val(data.ban_info);
                   $("#inlineForm").modal('show');
               });
            });

            $("#ban").click(function (e) {
                e.preventDefault();

                $("#ban").html('جاري الخفظ ..');
                $("#ban").attr('disabled',true);
                var agent_id = $("#_id").val();
                if(agent_id){
                   url = "{{ route('agents.index') }}"+ '/' + agent_id 
                   method="PATCH";}
                $.ajax({

                    data: $('#editFromData').serialize(),

                    url: url,

                    type: method,

                    dataType: 'json',
                    timeout:4000,
                    success: function (data) {
                        $("#ban").html(' حفظ');
                        $("#ban").attr('disabled',false);
                        $('#editFromData').trigger("reset");
                        showSuccesFunction();
                        $("#inlineForm").modal('hide');
                        table.draw(false);                       
                    },

                    error: function (data) {
                        $("#ban").html(' حفظ');
                        $("#ban").attr('disabled',false);
                        showErrorFunction();
                        $("#inlineForm").modal('hide');

                    }

                });
            }); // end save , update record data




       



        });

    </script>
@endpush

