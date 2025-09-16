@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>الأسئلة</p>
                        @can('إضافة سؤال')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addQuestionClick" class="btn btn-primary">إضافة</button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>السؤال</th>
                                            <th>الاختبار</th>
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

<!-- نموذج إضافة/تعديل السؤال -->
<div class="modal fade text-left" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="questionModalLabel">إضافة أو تعديل سؤال</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="questionForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>السؤال</label>
                            <div class="form-group">
                                <textarea name="question_text" id="question_text" placeholder="السؤال" class="form-control"></textarea>
                            </div>

                            <label>الاختبار</label>
                            <div class="form-group">
                                <select name="exam_id" id="exam_id" class="form-control">
                                    <option value="">اختيار الاختبار</option>
                                    @foreach($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                    @endforeach
                                </select>
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
            language: {
                processing: "جاري المعالجة...",
                search: "البحث:",
                lengthMenu: "إظهار _MENU_ صفوف",
                info: "عرض _START_ إلى _END_ من _TOTAL_ صفوف",
                infoEmpty: "لا توجد بيانات متاحة",
                paginate: {
                    first: "الأولى",
                    last: "الأخيرة",
                    next: "التالي",
                    previous: "السابق"
                },
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('questions.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'question_text', name: 'question_text' },
                { data: 'exam.name', name: 'exam.name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // إضافة سؤال
        $("#addQuestionClick").click(function () {
            $("#saveBtn").text("إضافة");
            $("#questionModalLabel").text("إضافة سؤال");
            $('#_id').val('');
            $('#questionForm').trigger("reset");
            $("#questionModal").modal("show");
        });

        // تعديل سؤال
        $('body').on('click', '.edit', function () {
            var question_id = $(this).data('id');
            $("#questionModalLabel").html("تعديل سؤال");
            $.get("{{ route('questions.index') }}" + '/' + question_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#question_text').val(data.question_text);
                $('#exam_id').val(data.exam_id);
                $("#questionModal").modal("show");
            });
        });

        // إرسال النموذج
        $("#questionForm").on('submit', function (e) {
            e.preventDefault();
            $("#saveBtn").html('جاري الحفظ..');
            $("#saveBtn").attr('disabled', true);

            var question_id = $("#_id").val();
            var method = question_id ? "PUT" : "POST";
            var url = question_id ? "{{ route('questions.update', '') }}" + '/' + question_id : "{{ route('questions.store') }}";

            var data = {
                "_token": "{{ csrf_token() }}",
                "exam_id": $("#exam_id").val(),
                "question_text": $("#question_text").val(),
            };

            $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: 'json',
                success: function (response) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    $('#questionForm').trigger("reset");
                    $("#questionModal").modal('hide');
                    showSuccesFunction();
                    table.draw(false);
                }, 
                error: function (data) {
            $("#saveBtn").html('حفظ');
            $("#saveBtn").attr('disabled', false);
            showErrorFunction();
            $("#studentModal").modal('hide');
                }
            });
        });

        // حذف سؤال
        $('body').on('click', '.delete', function () {
    var question_id = $(this).data("id");
    sweetConfirm(function (confirmed) {
        if (confirmed) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('questions.index') }}" + '/' + question_id,
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

