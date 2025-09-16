@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                            الشركات/المتاجر
                            </p><br>
                            {{-- <div class="row" style="margin: 20px;">
                                <button type="button" id="addClick" class="btn btn-primary">إضافة</button>

                            </div> --}}
                            <div class="row">

                                <div class="col-sm-12" style="overflow-x:auto;">
                                    <table class="table table-striped table-sm data-table">

                                        <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>الاسم بالعربي </th>
                                            <th> الاسم بالانكليزي</th>
                                            <th> مالك الشركة </th>
                                            <th> نوع الشركة</th>
                                            <th>المدينة  </th>
                                            <th> المنطقة </th>
                                            <th>رقم السجل العقاري  </th>
                                            <th>  التوصيل  </th>
                                            <th>  التعامل مع تطبيقات أخرى  </th>
                                            <th>     رابط الشركة</th>
                                            <th>      صورة الشركة</th>
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

            ajax: "{{ route('companies.index') }}",

            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'arabic_name', name: 'name'},
                {data: 'english_name', name: 'name'},
                {data: 'company_owner.name', name: 'name'},
                {data: 'company.type', name: 'type'},
                {data: 'city.name_ar', name: 'city_name'},
                {data: 'region.name_ar', name: 'region_name'},
                {data: 'commercial_registration_number', name: 'number'},
                {data: 'delivery', name: 'delivery'},
                {data: 'use_other_app', name: 'use_other_app'},
                {data: 'company_url', name: 'company_url'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action'},

                    ]

                    });



            $('body').on('click', '.delete', function () {
                var card_id = $(this).data("id");

                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({

            type: "DELETE",

            url: "{{ route('companies.index') }}"+ '/' + card_id,
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
