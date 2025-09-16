@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            اشتراكات المستخدمين
                        </p>

                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                        <tr>
                                            <th> #</th>
                                            <th>  المستخدم</th>
                                            <th> الاشتراك </th>
                                            <th>  السعر</th>
                                            <th> تاريخ الانتهاء  </th>
                                            <th> الحالة</th>

                                            <th>  العمليات</th>

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
                    <label class="modal-title text-text-bold-600" id="title">اشتراكات المستخدم  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>

                    </button>
                </div>
                <form action="#" method="post" id="editFromData">
                    @csrf
                    <input type="hidden" name="_id" id="_id">
                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6">
                            <label>  التاريخ </label>
                               <div class="form-group">
                                   <input type="date" name="date" id="date" placeholder="" class="form-control">

                               </div><br>
                               <br>


                               <label>  اختر الاشتراك </label>
                               <div class="form-group">

                               <select id="subscription_id" name="subscription_id" autocomplete="name"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach($subscriptions as $subscription)
                                    <option value="{{$subscription->id}}">{{$subscription->name}}</option>
                                    @endforeach

                                </select>

                               </div><br>



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

            ajax: "{{ route('user_subscriptions.index')}}",

            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'subscription_id',
                    name: 'subscription_id'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'state',
                    name: 'state'
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
            $('#_id').val('') ;
            $('#editFromData').trigger("reset");
            $("#inlineForm").modal("show");
        });


               $('body').on('click', '.edit', function() {

var product_id = $(this).data('id');
$("#title").html("تعديل ");
$.get("{{ route('user_subscriptions.index') }}" + '/' + product_id + '/edit', function(data) {
                   $("#saveBtn").val("حفظ");
                   $('#_id').val(data.id);
                   $('#subscription_id').val(data.subscription_id);
                   $('#date').val(data.date);

                       $("#inlineForm").modal('show');

})


           }) ;// end edit function;

           $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('جاري الخفظ ..');
                $("#saveBtn").attr('disabled',true);
                var card_id = $("#_id").val();
                var method="post";
                var url = "{{ route('user_subscriptions.store') }}";
                if(card_id){
                   url = "{{ route('user_subscriptions.index') }}"+ '/' + card_id
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

        $('body').on('click', '.delete', function() {
            var product_id = $(this).data("id");
            sweetConfirm(function(confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('user_subscriptions.index') }}" + '/' + product_id,
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


        $('body').on('click', '.decline', function () {
    var product_id = $(this).data("id");
    $("#title").html(" رفض ");

    sweetConfirm(function(confirmed) {
        if (confirmed) {
            var url = "{{ route('usersub_decline', ':id') }}";
            url = url.replace(':id', product_id);
            $.ajax({
                type: "post",
                url: url,

                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(data) {
                    showSuccessFunction();
                    table.draw(false);
                },

            });
        }
    });
});/// end of decline
$('body').on('click', '.accept', function () {
    var product_id = $(this).data("id");
    $("#title").html(" رفض ");

    sweetConfirm(function(confirmed) {
        if (confirmed) {
            var url = "{{ route('usersub_accept', ':id') }}";
            url = url.replace(':id', product_id);
            $.ajax({
                type: "post",
                url: url,

                data: {
                    '_token': '{{csrf_token()}}'
                },
                success: function(data) {
                    showSuccessFunction();
                    table.draw(false);
                },

            });
        }
    });
});/// end of accept


    });
</script>
@endpush
