@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                            المستخدمين
                        </p>
                        @can('اضافة مستخدم')
                        <div class="row" style="margin: 20px;">
                                <button type="button" id="addClick" class="btn btn-primary">إضافة</button>

                            </div>
                        @endcan
                        <br>
                        <div class="row">

                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">

                                    <thead>


                                    <tr>
    <th> # </th>
    <th> الاسم </th>
    <th> الايميل </th>
    <th> رقم الهاتف </th>
    <th> الجنسية </th>
    <th> المؤهل العملي </th>
    <th> الدور </th>
    <th> الاشتراك </th>
    <th> العمليات </th>
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
                    <label class="modal-title text-text-bold-600" id="title">مستخدمين  </label>
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
                <!-- الاسم -->
                <label>الاسم</label>
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="" class="form-control">
                </div><br>

                <!-- الايميل -->
                <label>الايميل</label>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="" class="form-control">
                </div><br>

                <!-- رقم الهاتف -->
                <label>رقم الهاتف</label>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" placeholder="" class="form-control">
                </div><br>

                <!-- الجنسية -->
                <label>الجنسية</label>
                <div class="form-group">
                    <select id="gender" name="gender" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="0">ذكر</option>
                        <option value="1">أنثى</option>
                    </select>
                </div><br>

                <!-- المؤهل العملي -->
                <label>المؤهل العملي</label>
                <div class="form-group">
                    <input type="text" name="qualification" id="qualification" placeholder="" class="form-control">
                </div><br>

                <!-- الدور -->
                <label>الدور</label>
                <div class="form-group">
                    <select id="role" name="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div><br>

                <!-- الاشتراك -->
                <label>الاشتراك</label>
                <div class="form-group">
                    <input type="text" name="subscription" id="subscription" placeholder="" class="form-control">
                </div><br>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group">
                    <div class="needsclick dropzone" id="document-dropzone">
                    </div><br>
                </fieldset>
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
    <!--                                               subscription                                          -->
    <div class="modal fade text-left" id="inlinenoteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="title"> اضافة اشتراك  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>

                    </button>
                </div>
                <form action="#" method="post" id="editnoteData ">
                    @csrf

                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6">




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


                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                        <input type="submit" id="savenote" class="btn btn-primary" value="حفظ">
                                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('pageJs')
{{--dropzone--}}

<script>
Dropzone.autoDiscover = false;
var uploadedDocumentMap = {}
var alesDropZone  =   new Dropzone( "#document-dropzone", {
    url: '{{ route("projects.storeMedia",["table"=>"users"]) }}',
    maxFiles:1,
    maxFilesize: 2, // MB
    addRemoveLinks: true,
     headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    processing:function(){
        $('#saveBtn').prop('disabled',true);
        toastr.options.positionClass = 'toast-top-center';
        toastr.warning('انتظر اكتمال التحميل');
    },
    init: function() {
        this.on('addedfile', function(file) {
         if (this.files.length > 1) {
        this.removeFile(this.files[1]);
        toastr.options.positionClass = 'toast-top-center';
        toastr.success('لايمكن رفع اكثر من ملف');}
  });
// this.hiddenFileInput.removeAttribute('multiple');
    },
    success: function (file, response) {
        $('#editFromData').append('<input type="hidden" name="avatar" value="' + response.name + '">')

        uploadedDocumentMap[file.name] = response.name
        $('#saveBtn').prop('disabled',false);
    },
    removedfile: function (file) {
        file.previewElement.remove()
        var name = ''
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedDocumentMap[file.name]
        }
        $('#editFromData').find('input[name="avatar"][value="' + name + '"]').remove()
    },

});
</script>

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

            ajax: "{{ route('agents.index')}}",

            columns: [
    {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
    },
    {
        data: 'name',
        name: 'name'
    },
    {
        data: 'email',
        name: 'email'
    },
    {
        data: 'phone',
        name: 'phone'
    },
    {
        data: 'nationality',  // تم تعديلها لتكون الجنسية بدلاً من gender
        name: 'nationality'
    },
    {
        data: 'qualification',  // تم تعديلها لتكون المؤهل العملي بدلاً من الوزن أو الطول
        name: 'qualification'
    },
    {
        data: 'role',
        name: 'role'
    },
    {
        data: 'subscription',
        name: 'subscription'
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

        $('body').on('click', '.edit', function () {

               var product_id = $(this).data('id');
               $("#title").html("تعديل ");
               $.get("{{ route('agents.index') }}" + '/' + product_id + '/edit', function (data) {
                   $("#saveBtn").val("حفظ");
                   $('#_id').val(data.id);
                   $('#name').val(data.name);
                   $('#email').val(data.email);
                   $('#password').val(data.password);
                   $('#phone').val(data.phone);
                   $('#role').val(data.role);
                   $('#gender').val(data.gender);
                   $('#birthday').val(data.birthday);
                   $('#weight').val(data.weight);
                   $('#height').val(data.height);
                   var icon_s = "<img src='{{asset('/storage/')}}/"+data.avatar+"' width='120' height='120'>";
                   $("#card-drag-area").html(icon_s);
                   $("#inlineForm").modal('show');
               })


           }) ;// end edit function;

           $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('جاري الخفظ ..');
                $("#saveBtn").attr('disabled',true);
                var card_id = $("#_id").val();
                var method="post";
                var url = "{{ route('agents.store') }}";
                if(card_id){
                   url = "{{ route('agents.index') }}"+ '/' + card_id
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
                        url: "{{ route('agents.index') }}" + '/' + product_id,
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
        $(document).on('click', '.profile', function(e) {
    e.preventDefault();
    var product_id = $(this).data("id");
    var url = "{{ route('user_profile', ':id') }}";
    url = url.replace(':id', product_id);
    window.location.href = url;

});///display user's profile

        $(document).on('click', '.add', function(e) {
    e.preventDefault();
    clickedElementId = $(this).data('id');
    $("#savenote").html("إضافة");
    $('#' + clickedElementId).val('');
    $('#editnoteData').trigger("reset");
    $("#inlinenoteForm").modal("show");
});

$("#savenote").click(function (e) {
    e.preventDefault();
    var subscription_id = $('#subscription_id').val();
    var url =  "{{ route('addsubscription','id')}}";
    url = url.replace('id', clickedElementId);

    $.ajax({
        url:url,
        type: "GET",
        data: {
            subscription_id: subscription_id,
        },
        success: function(response) {
            $("#savenote").html(' حفظ');
            $("#savenote").attr('disabled',false);
            $('#editnoteData').trigger("reset");
            showSuccesFunction();
            $("#inlinenoteForm").modal('hide');
            table.draw(false);
        },
        error: function (data) {
            $("#savenote").html(' حفظ');
            $("#savenote").attr('disabled',false);
            showErrorFunction();
            $("#inlinenoteForm").modal('hide');
        }
    });
});


    });
</script>


@endpush
