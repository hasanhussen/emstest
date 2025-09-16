@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            الدول
                        </p>

                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table" id="countries_table">

                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th> اسم البلد </th>
                                            <th>Name</th>
                                            <th>العلم</th>
                                            <th>العمليات</th>

                                        

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


        var table = $('#countries_table').DataTable({
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

            ajax: "{{ route('countries.index') }}",

            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name_ar',
                    name: 'name_ar'
                },
                {
                    data: 'name_en',
                    name: 'name_en'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                  
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
              

            ]

        });
        $("#addClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#title").html(" إاضافة صورة");
            $('#_id').val('') ;
            $('#editFromData').trigger("reset");
            $("#inlineForm").modal("show");
            alesDropZone.removeAllFiles(true);
            $("#image_sub").html("");
            $("#card-drag-area").html("");
        }); 

   
           
          

        $('body').on('click', '.delete', function() {
            var product_id = $(this).data("id");
            sweetConfirm(function(confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('countries.index') }}" + '/' + product_id,
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function(data) {
                            showSuccesFunction();
                            table.draw(false);
                        },
                        error: function(data) {}
                    });
                }

            });

        }); // end delete row
    });
</script>

@endpush