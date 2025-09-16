@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                           من نحن
                            </p>
                      
                            <div class="row">

                                <div class="col-sm-12" style="overflow-x:auto;">
                                    <table class="table table-striped table-sm data-table">

                                        <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>العنوان   </th>
                                            <th>الهاتف   </th>
                                            <th>الايميل   </th>
                                            <th>فيسبوك   </th>
                                            <th>انستغرام   </th>
                                            <th>تويتر   </th>
                                            <th>واتساب   </th>
                                            <th>تيلغرام   </th>
                                            <th>لمحة عامة   </th>
                                            <th>الايقونة   </th>
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
                           
                               <label for="roundText">  الأيقونة</label>
                                  <div class="container">
                               <section id="draggable-cards">
                                   <div class="row match-height" id="card-drag-area">

                                   </div>

                               </section>
                           </div><br>
                               <label>  الايميل </label>
                               <div class="form-group">
                                   <input type="email" name="email" id="email" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>   العنوان </label>
                               <div class="form-group">
                                   <input type="text" name="title" id="title" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>  رقم الهاتف </label>
                               <div class="form-group">
                                   <input type="text" name="phone" id="phone" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>  فيسبوك </label>
                               <div class="form-group">
                                   <input type="text" name="facebook" id="facebook" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>   انستغرام </label>
                               <div class="form-group">
                                   <input type="text" name="instagram" id="instagram" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>   تويتر </label>
                               <div class="form-group">
                                   <input type="text" name="twitter" id="twitter" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>  واتساب </label>
                               <div class="form-group">
                                   <input type="text" name="whatsApp" id="whatsApp" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>   تيلغرام </label>
                               <div class="form-group">
                                   <input type="text" name="telegram" id="telegram" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                               <label>   لمحة عامة </label>
                               <div class="form-group">
                                   <input type="text" name="overview" id="overview" placeholder="" class="form-control">
                                   <div id="img-list">

                                   </div>
                               </div><br>
                        </div>
                           <div class="col-md-6">
                               <fieldset class="form-group">
                                <div class="needsclick dropzone" id="document-dropzone">
                                </div> <br>



              
                                </fieldset>
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
    {{--dropzone--}}

    <script>
Dropzone.autoDiscover = false;
var uploadedDocumentMap = {}
var alesDropZone  =   new Dropzone( "#document-dropzone", {
    url: '{{ route("projects.storeMedia",["table"=>"about"]) }}',
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
        $('#editFromData').append('<input type="hidden" name="image" value="' + response.name + '">')

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
        $('#editFromData').find('input[name="image"][value="' + name + '"]').remove()
    },

});
</script>
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

            ajax: "{{ route('about.index') }}",

            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
              
                {
                    data: 'facebook',
                    name: 'facebook'
                },
                {
                    data: 'instagram',
                    name: 'instagram'
                },
                {
                    data: 'twitter',
                    name: 'twitter'
                },
                {
                    data: 'whatsApp',
                    name: 'whatsApp'
                },
                {
                    data: 'telegram',
                    name: 'telegram'
                },
                {
                    data: 'overview',
                    name: 'overview'
                },
             
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action'},

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
                $.get("{{ route('about.index') }}" + '/' + product_id + '/edit', function (data) {
                    $("#saveBtn").val("حفظ");
                    $('#_id').val(data.id);
                    $('#title').val(data.title);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                    $('#overview').val(data.overview);
                    $('#facebook').val(data.facebook);
                    $('#twitter').val(data.twitter);
                    $('#instagram').val(data.instagram);
                    $('#whatsApp').val(data.whatsApp);
                    $('#telegram').val(data.telegram);
                    var icon_s = "<img src='{{asset('/storage')}}/"+data.image+"' width='120' height='120'>";
                    $("#card-drag-area").html(icon_s);
                    alesDropZone.removeAllFiles(true);
                    $("#inlineForm").modal('show');
                })


            }) ;// end edit function;

             
            $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('جاري الخفظ ..');
                $("#saveBtn").attr('disabled',true);
                var card_id = $("#_id").val();
                var method="post";
                var url = "{{ route('about.store') }}";
                if(card_id){
                   url = "{{ route('about.index') }}"+ '/' + card_id 
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


            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "DELETE",
            url: "{{ route('about.index') }}"+ '/' + product_id,
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
