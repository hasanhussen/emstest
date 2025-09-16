@extends("admin.layout")
@section('content')


<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                    <p>
                        الشكاوى
                    </p><br>

                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> المشتكي </th>
                                        <th> المشتكى عليه </th>
                                        <th>  نوع الشكوى </th>
                                        <th> تاريخ الشكوى </th>
                                        <th> معلومات الشكوى </th>
                                        <th> صورة </th>
                                        <th> تعويض </th>
                                        <th >العمليات </th>

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
                       <div class="col-md-6"> <label>   ملاحظات الشكوى </label>
                           <div class="form-group">
                               <input type="text" name="notes" id="notes" placeholder="" class="form-control">
                               <div id="img-list">

                               </div>
                           </div>

                    </div>

                   </div>


                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">

                </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade text-left" id="commentForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="myModalLabel33">  القيمة المعوضة </label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="editComments">
                @csrf
                <input type="hidden" name="product_id" id="product_id">


                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"> <label>    القيمة </label>
                            <div class="form-group">
                                <input type="text" name="value" id="value" placeholder="" class="form-control">

                            </div>

                     </div>

                    </div>


                 </div>
                <div class="modal-footer">
                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                    <input type="submit" id="send" class="btn btn-primary" value="ارسال التعويض">

                </div>
            </form>
        </div>
    </div>
</div>




@endsection


@push('pageJs')

    <script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
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

            ajax: "{{ route('complains.index') }}",

            columns: [ 

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user1.name', name: 'user1'},
                {data: 'user2.name', name: 'user1'},
                {data: 'complain_type.type', name: 'type'},
                {data: 'complain_date', name: 'type'},
                {data: 'notes', name: 'notes'},
                {data: 'image', name: 'image'},
                {data: 'value', name: 'value'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

]

});

            $('body').on('click', '.show', function () {

            var complain_id = $(this).data('id');
            $.get("{{ route('complains.index') }}" + '/' + complain_id +'/edit', function (data) {
                $('#id').val(data.id);
                $('#notes').val(data.notes);
                $("#inlineForm").modal('show');
            });

                });
                // هون في شي


            $('body').on('click', '.value', function () {

                var product_id = $(this).data('id');
                $.get("{{ route('repayment.index') }}" + '/' + product_id , function (data) {
                    $("#saveBtn").val("حفظ");
                    $('#id').val(data.id);
                    $('#value').val(data.value);
                    $("#commentForm").modal('show');
                });
            });


            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "POST",
            url: "{{ url('delete_complain') }}/"+  product_id ,
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


            }) ;// end delete function;




});



    </script>

@endpush
