@extends("admin.layout")

@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p>المستخدمون</p>
                        @can('اضافة مستخدم')
                        <div class="row" style="margin: 20px;">
                            <button type="button" id="addUserClick" class="btn btn-primary">إضافة </button>
                        </div>
                        @endcan
                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table class="table table-striped table-sm data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>الدور</th>
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

<!-- نموذج إضافة/تعديل المستخدم -->
<div class="modal fade text-left" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title text-text-bold-600" id="userModalLabel">إضافة أو تعديل مستخدم</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <form action="#" method="post" id="userForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_id" id="_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label>الاسم</label>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="الاسم" class="form-control">
                            </div>

                            <label>البريد الإلكتروني</label>
                            <div class="form-group">
                                <input type="email" name="email" id="email" placeholder="البريد الإلكتروني" class="form-control">
                            </div>

                            <label>كلمة المرور</label>
                            <div class="form-group">
                                <input type="password" name="password" id="password" placeholder="كلمة المرور" class="form-control">
                            </div>

                            <label>الدور</label>
                            <div class="form-group">
                                <select name="role" id="role" class="form-control">
                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
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
                url: "{{ route('students.index') }}",
                type: "GET",
                dataType: "json"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'action', name: 'action' }
            ]
        });

        // إضافة مستخدم جديد
        $("#addUserClick").click(function () {
    $("#saveBtn").text("إضافة");
    $("#userModalLabel").text("إضافة مستخدم");
    $('#_id').val('');
    $('#userForm').trigger("reset");
    $("#userModal").modal("show");
});


        // تعديل المستخدم
        $('body').on('click', '.edit', function () {
            var user_id = $(this).data('id');
            $("#userModalLabel").html("تعديل مستخدم");
            $.get("{{ route('students.index') }}" + '/' + user_id + '/edit', function (data) {
                $("#saveBtn").val("حفظ");
                $('#_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#role').val(data.role);
                $("#userModal").modal('show');
            });
        });

        // حفظ أو تحديث المستخدم
        $("#userForm").on('submit', function (e) {
    e.preventDefault();
    $("#saveBtn").html('جاري الحفظ..');
    $("#saveBtn").attr('disabled', true);

    var user_id = $("#_id").val();
    var method = user_id ? "PUT" : "POST";
    var url = user_id ? "{{ route('students.update', '') }}" + '/' + user_id : "{{ route('students.store') }}";

    var data = {
        "_token": "{{ csrf_token() }}",
        "name": $("#name").val(),
        "email": $("#email").val(),
        "password": $("#password").val(),
        "role": $("#role").val(),
    };

    $.ajax({
        url: url,
        type: method,
        data: data,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            $("#saveBtn").html('حفظ');
            $("#saveBtn").attr('disabled', false);
            $('#userForm').trigger("reset");
            showSuccesFunction();
            $("#userModal").modal('hide');
            table.draw(false);
        },
        error: function (data) {
            $("#saveBtn").html('حفظ');
            $("#saveBtn").attr('disabled', false);
            showErrorFunction();
            $("#userModal").modal('hide');
        }
    });
});


        // حذف المستخدم
        $('body').on('click', '.delete', function () {
    var user_id = $(this).data("id");
    sweetConfirm(function (confirmed) {
        if (confirmed) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('students.index') }}" + '/' + user_id,
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
