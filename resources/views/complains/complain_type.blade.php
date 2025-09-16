@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                            نوع الشكوى
                            </p>
                            <div class="row" style="margin: 20px;">
                                <button type="button" id="addClick" class="btn btn-primary">إضافة</button>

                            </div>
                            <div class="row">

                                <div class="col-sm-12" style="overflow-x:auto;">
                                    <table class="table table-striped table-sm data-table">

                                        <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>نوع الشكوى</th>
                                            <th >العمليات</th>

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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="title">الشكوى   </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>

                    </button>
                </div>
                <form action="#" method="post" id="editFromData">
                    @csrf
                    <input type="hidden" name="_id" id="_id">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6"> <label>  نوع الشكوى </label>
                               <div class="form-group">
                                   <input type="text" name="type" id="type" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div>
                         
                        </div>
                      
                       </div>


                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                        <input type="submit" id="saveBtn" class="btn btn-primary" value="حفظ">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('pageJs')
    
    <script type="text/javascript">

        $(function () {


            var table = $('.data-table').DataTable({
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
            destroy: true,
            processing: true,
            serverSide: true,
            stateSave: true,

            ajax: "{{ route('complain_type.index') }}",

            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'type', name: 'type'},
                {data: 'action', name: 'action'},

]

});


        $("#addClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#title").html(" إضافة شكوى");
            $('#_id').val('') ;
            $('#editFromData').trigger("reset");
            $("#inlineForm").modal("show");
        });


            $('body').on('click', '.edit', function () {
               
                var product_id = $(this).data('id');
                $("#title").html("تعديل ");
                $.get("{{ route('complain_type.index') }}" + '/' + product_id + '/edit', function (data) {
                    $("#saveBtn").val("حفظ");
                    $('#_id').val(data.id);
                    $('#type').val(data.type);
                   $("#inlineForm").modal('show');
                })


            }) ;// end edit function;

            $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('جاري الخفظ ..');
                $("#saveBtn").attr('disabled',true);
                var card_id = $("#_id").val();
                var method="post";
                var url = "{{ route('complain_type.store') }}";
                if(card_id){
                   url = "{{ route('complain_type.index') }}"+ '/' + card_id 
                   method="PATCH";}
                $.ajax({

                    data: $('#editFromData').serialize(),

                    url: url,

                    type: method,

                    dataType: 'json',
                    timeout:4000,
                    success: function (data) {
                        $("#saveBtn").html(' حفظ');
                        $("#saveBtn").attr('disabled',false);
                        $('#editFromData').trigger("reset");
                        showSuccesFunction();
                        $("#inlineForm").modal('hide');
                        table.draw(false);                       
                    },

                    error: function (data) {
                        $("#saveBtn").html(' حفظ');
                        $("#saveBtn").attr('disabled',false);
                        showErrorFunction();
                        $("#inlineForm").modal('hide');

                    }

                });
            }); // end save , update record data



            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "DELETE",
            url: "{{ route('complain_type.index') }}"+ '/' + product_id,
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
