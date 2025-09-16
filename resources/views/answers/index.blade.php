@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>الإجابات</p>
                        @can('إضافة إجابة')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addAnswerClick" class="btn btn-primary">إضافة</button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الإجابة</th>
                                            <th>السؤال</th>
                                            <th>هل هي صحيحة؟</th>
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

<!-- نموذج إضافة/تعديل الإجابة -->
<div class="modal fade text-left" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="answerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="answerModalLabel">إضافة أو تعديل إجابة</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="answerForm">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>الإجابة</label>
                            <div class="form-group">
                                <input type="text" name="answer_text" id="answer_text" placeholder="الإجابة" class="form-control">
                            </div>

                            <label>السؤال</label>
                            <div class="form-group">
                                <select name="question_id" id="question_id" class="form-control">
                                    @foreach($questions as $question)
                                    <option value="{{ $question->id }}">{{ $question->question_text }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label>هل هي صحيحة؟</label>
                            <div class="form-group">
                                <input type="hidden" name="is_correct" value="0"> <!-- إرسال قيمة false -->
                                <input type="checkbox" name="is_correct" id="is_correct" value="1">
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
                url: "{{ route('answers.index') }}",
                type: "GET",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'answer_text', name: 'answer_text' },
                { data: 'question.question_text', name: 'question.question_text' },
                { data: 'is_correct', name: 'is_correct' },
                { data: 'action', name: 'action' }
            ]
        });

        // إضافة إجابة جديدة
        $("#addAnswerClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#answerModalLabel").html("إضافة إجابة");
            $('#_id').val('');
            $('#answerForm').trigger("reset");
            $("#answerModal").modal("show");
        });

        // تعديل الإجابة
        $('body').on('click', '.edit', function () {
            var answer_id = $(this).data('id');
            $("#answerModalLabel").html("تعديل إجابة");
            $.get("{{ route('answers.index') }}" + '/' + answer_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $("#answerModal").modal('show');
            });
        });

        // حفظ أو تحديث الإجابة
        $("#answerForm").on('submit', function (e) {
            e.preventDefault();
            $("#saveBtn").html('جاري الحفظ..');
            $("#saveBtn").attr('disabled', true);
            var answer_id = $("#_id").val();
            var method = answer_id ? "PUT" : "POST";
            var url = answer_id ? "{{ route('answers.update', '') }}" + '/' + answer_id : "{{ route('answers.store') }}";

            $.ajax({
                data: $('#answerForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    $('#answerForm').trigger("reset");
                    showSuccesFunction();
                    $("#answerModal").modal('hide');
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

        $('body').on('click', '.delete', function () {
            var answer_id = $(this).data("id");
            sweetConfirm(function (confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('answers.index') }}" + '/' + answer_id,
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
