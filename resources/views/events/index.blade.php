@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>الفعاليات</p>
                        @can('إضافة فعالية')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addEventClick" class="btn btn-primary">إضافة</button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>النوع</th>
                                            <th>المتحدثين</th>
                                            <th>عدد المشاركين</th>
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

<!-- نموذج إضافة/تعديل الفعالية -->
<div class="modal fade text-left" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="eventModalLabel">إضافة أو تعديل فعالية</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="eventForm">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>الاسم</label>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="الاسم" class="form-control">
                            </div>

                            <label>النوع</label>
                            <div class="form-group">
                                <select name="type" id="type" class="form-control">
                                    <option value="ورشة عمل">ورشة عمل</option>
                                    <option value="مؤتمر">مؤتمر</option>
                                    <option value="ندوة">ندوة</option>
                                </select>
                            </div>

                            <label>تاريخ الفعالية</label>
                            <div class="form-group">
                                <input type="date" name="event_date" id="event_date" class="form-control">
                            </div>

                            <label>المتحدثين</label>
                            <div class="form-group">
                                <input type="text" name="speakers" id="speakers" placeholder="المتحدثين" class="form-control">
                            </div>

                            <label>عدد المشاركين</label>
                            <div class="form-group">
                                <input type="number" name="participants" id="participants" placeholder="عدد المشاركين" class="form-control">
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
                url: "{{ route('events.index') }}",
                type: "GET",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'speakers', name: 'speakers' },
                { data: 'participants', name: 'participants' },
                { data: 'action', name: 'action' }
            ]
        });

        // إضافة فعالية جديدة
        $("#addEventClick").click(function (e) {
            e.preventDefault();
            $("#saveBtn").html("إضافة");
            $("#eventModalLabel").html("إضافة فعالية");
            $('#_id').val('');
            $('#eventForm').trigger("reset");
            $("#eventModal").modal("show");
        });

        // تعديل الفعالية
        $('body').on('click', '.edit', function () {
            var event_id = $(this).data('id');
            $("#eventModalLabel").html("تعديل فعالية");
            $.get("{{ route('events.index') }}" + '/' + event_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#name').val(data.name);
                $('#type').val(data.type);
                $('#event_date').val(data.event_date);
                $('#speakers').val(data.speakers);
                $('#participants').val(data.participants);
                $("#eventModal").modal('show');
            });
        });

        // حفظ أو تحديث الفعالية
        $("#eventForm").on('submit', function (e) {
            e.preventDefault();
            $("#saveBtn").html('جاري الحفظ..');
            $("#saveBtn").attr('disabled', true);
            var event_id = $("#_id").val();
            var method = event_id ? "PUT" : "POST";
            var url = event_id ? "{{ route('events.update', '') }}" + '/' + event_id : "{{ route('events.store') }}";

            $.ajax({
                data: $('#eventForm').serialize(),
                url: url,
                type: method,
                dataType: 'json',
                success: function (data) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    $('#eventForm').trigger("reset");
                    showSuccesFunction();
                    $("#eventModal").modal('hide');
                    table.draw(false);
                },
                error: function (data) {
                    $("#saveBtn").html('حفظ');
                    $("#saveBtn").attr('disabled', false);
                    showErrorFunction();
                    $("#eventModal").modal('hide');
                }
            });
        });

        // حذف الفعالية
        $('body').on('click', '.delete', function () {
            var event_id = $(this).data("id");
            sweetConfirm(function (confirmed) {
                if (confirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('events.index') }}" + '/' + event_id,
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
