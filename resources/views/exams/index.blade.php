@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>الامتحانات</p>
                        @can('إضافة امتحان')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addExamClick" class="btn btn-primary">إضافة</button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>المادة</th>
                                            <th>تاريخ الامتحان</th>

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

<!-- نموذج إضافة/تعديل الامتحان -->
<div class="modal fade text-left" id="examModal" tabindex="-1" role="dialog" aria-labelledby="examModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="examModalLabel">إضافة أو تعديل امتحان</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="examForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>الاسم</label>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="الاسم" class="form-control">
                            </div>

                            <label>المادة</label>
                            <div class="form-group">
                            <select name="subject_id" id="subject_id" class="form-control">
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                            </select>
                            </div>

                            <label>تاريخ الامتحان</label>
                            <div class="form-group">
                                <input type="datetime-local" name="exam_date" id="exam_date" class="form-control">
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
                url: "{{ route('exams.index') }}",
                type: "GET",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'subject.name', name: 'subject.name' },
                { data: 'exam_date', name: 'exam_date' },
                { data: 'action', name: 'action' }
            ]
        });

        // إضافة امتحان جديد
        $("#addExamClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#examModalLabel").html("إضافة امتحان");
            $('#_id').val('');
            $('#examForm').trigger("reset");
            $("#examModal").modal("show");
        });

        // تعديل الامتحان
        $('body').on('click', '.edit', function () {
            var exam_id = $(this).data('id');
            $("#examModalLabel").html("تعديل امتحان");
            $.get("{{ route('exams.index') }}" + '/' + exam_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#name').val(data.name);
                $('#subject_id').val(data.subject_id);
                $('#exam_date').val(data.exam_date);
                $("#examModal").modal('show');
            });
        });

        // حفظ أو تحديث الامتحان
        $("#examForm").on('submit', function (e) {
            e.preventDefault();
            $("#saveBtn").html('جاري الحفظ..');
            $("#saveBtn").attr('disabled', true);
            var exam_id = $("#_id").val();
            var method = exam_id ? "PUT" : "POST";
            var url = exam_id ? "{{ route('exams.update', '') }}" + '/' + exam_id : "{{ route('exams.store') }}";

            $.ajax({
                data: new FormData(this),
                url: url,
                type: method,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    $('#examForm').trigger("reset");
                    showSuccesFunction();
                    $("#examModal").modal('hide');
                    table.draw(false);
                },
                error: function (data) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    showErrorFunction();
                    $("#examModal").modal('hide');
                }
            });
        });

        // حذف الامتحان
        $('body').on('click', '.delete', function () {
            var exam_id = $(this).data("id");
            sweetConfirm(function (confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('exams.index') }}" + '/' + exam_id,
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
