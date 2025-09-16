@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>المواد</p>
                        @can('إضافة مادة')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addSubjectClick" class="btn btn-primary">إضافة</button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>الوصف</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- سيتم ملء البيانات هنا بواسطة DataTable -->
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

<!-- نموذج إضافة/تعديل المادة -->
<div class="modal fade text-left" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="subjectModalLabel">إضافة أو تعديل مادة</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="subjectForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>الاسم</label>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="الاسم" class="form-control">
                            </div>

                            <label>الوصف</label>
                            <div class="form-group">
                                <textarea name="description" id="description" placeholder="الوصف" class="form-control"></textarea>
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
                "processing": "جاري المعالجة",
                "paginate": {
                    "first": "الأولى",
                    "last": "الأخيرة",
                    "next": "التالية",
                    "previous": "السابقة"
                },
                "search": "البحث :",
                "loadingRecords": "جاري التحميل...",
                "emptyTable": "لا توجد بيانات",
                "info": "من إظهار _START_ إلى _END_ من _TOTAL_ النتائج",
                "infoEmpty": "عرض 0 إلى 0 من 0 نتائج",
                "lengthMenu": "إظهار _MENU_ البيانات",
            },
            destroy: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('subjects.index') }}",
                type: "GET",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'action', name: 'action' }
            ]
        });

        // إضافة مادة جديدة
        $("#addSubjectClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#subjectModalLabel").html("إضافة مادة");
            $('#_id').val('');
            $('#_method').val('POST');
            $('#subjectForm').trigger("reset");
            $("#subjectModal").modal("show");
        });

        // تعديل المادة
        $('body').on('click', '.edit', function () {
            var subject_id = $(this).data('id');
            $("#subjectModalLabel").html("تعديل مادة");
            $.get("{{ route('subjects.index') }}" + '/' + subject_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $("#subjectModal").modal('show');
            });
        });

        // حفظ أو تحديث المادة
        $("#subjectForm").on('submit', function (e) {
    e.preventDefault();
    $("#saveBtn").html('جاري الحفظ..');
    $("#saveBtn").attr('disabled', true);

    var subject_id = $("#_id").val();
    var method = subject_id ? "PUT" : "POST";
    var url = subject_id ? "{{ route('subjects.update', '') }}" + '/' + subject_id : "{{ route('subjects.store') }}";

    $.ajax({
        data: $('#subjectForm').serialize(),
        url: url,
        type: method,
        dataType: 'json',
        success: function (data) {
            $("#saveBtn").html('حفظ');
            $("#saveBtn").attr('disabled', false);
            $('#subjectForm').trigger("reset");
            showSuccesFunction();
            $("#subjectModal").modal('hide');
            table.draw(false);
        },
        error: function (data) {
            $("#saveBtn").html('حفظ');
            $("#saveBtn").attr('disabled', false);
            showErrorFunction();
            $("#subjectModal").modal('hide');
        }
    });
});


        // حذف المادة
        $('body').on('click', '.delete', function () {
            var subject_id = $(this).data("id");
            sweetConfirm(function (confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('subjects.index') }}" + '/' + subject_id,
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        success: function (data) {
                            showSuccesFunction();
                            table.draw(false);
                        },
                        error: function (data) { }
                    });
                }
            });
        });
    });
</script>

@endpush
