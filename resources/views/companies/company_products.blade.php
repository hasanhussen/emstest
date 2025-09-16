@extends("admin.layout")
@section('content')

    <section id="input-style">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-content">
                        <div class="card-body">
                            <p>
                            محتويات الشركة/المتجر 
                            </p>
                            {{-- <div class="row" style="margin: 20px;">
                                <button type="button" id="addClick" class="btn btn-primary">إضافة</button>

                            </div> --}}
                            <div class="row">

                                <div class="col-sm-12" style="overflow-x:auto;">
                                    <table class="table table-striped table-sm data-table">

                                        <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>اسم الشركة </th>
                                            <th>اسم المنتج</th>
                                            <th>سعر المنتج </th>
                                            <th>السعرات الحرارية  </th>
                                            <th> محتويات المنتج  </th>
                                            <th>الصورة   </th>
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
    <div class="modal fade text-left" id="subForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">   مكونات المنتج </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <form action="#" method="post" id="editFromDataSubs">
                    @csrf
                    <input type="hidden" name="_product_id" id="_product_id">
                    <div class="modal-body">

                        <div class="form-group">
                            <fieldset>
                            <div class="row">

                                    <div class="col-md-6">
                                     <label >  اسم المكون </label>
                                        <div class="form-group">
                                    <input type="text" id="component_name" name="component_name" class="form-control" placeholder=" ">
                                </div>
                              </div>

                              <div class="   justify-content-center " >
                                <label >   <br> </label>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="add_component" type="button" >إضافة </button>
                                </div> </div>
                            
                            </div>
                        

                            </fieldset>
                        </div>

                        </div>
                    <div id="subs_content">
                        <div class="col-sm-12" id="sortable-lists" >
                        <ul class="list-group" id="basic-list-group">



                        </ul>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                        <input type="submit" id="saveSortBtn" class="btn btn-primary" value="حفظ الترتيب">
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
        url: '{{ route('projects.storeMedia',["table"=>"company_products"]) }}',
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

            ajax: "{{ route('company_products.index') }}",

            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},

                {data: 'comp_product.arabic_name', name: 'arabic_name'},
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'calories', name: 'calories'},
                {data: 'components', name: 'components'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action'},

]

});




            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "DELETE",
            url: "{{ route('company_products.index') }}"+ '/' + product_id,
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

            




            $('body').on('click', '.component', function (e) {
                e.preventDefault();
                $('#editFromDataSubs').trigger("reset");
                var product_id=$(this).data('id');
                $("#_product_id").val(product_id);
                $.get("{{ url('product') }}" + '/' + product_id + '/components', function (data) {
                    $("#basic-list-group").html("");

                var arrayData = data;
                for (var i = 0; i < arrayData.length; i++) {
                    var html = " <li class=\"list-group-item draggable\">\n" +
                        "   <input type=\"hidden\" name=\"sort_order[]\" value='" + arrayData[i].id + "'>\n" +
                        "   <input type=\"hidden\" name=\"component_id[]\" value='" + arrayData[i].id + "'>\n" +

                        "   <div class=\"media\">\n" +
                        "\n" +
                        "  <div class=\" row media-body\">\n" + "  <div class=\" col-6\">\n" +
                        "     <h5 class=\"mt-0\"><input type='text' name='name[]' value='"+ arrayData[i].name + "' class='form-control' > </h5>" +
                        "  </div >" +"  <div class=\" col-6\">\n" +
                        
                        "<button class='btn btn-danger deleteSub' data-id='"+arrayData[i].id+"'> <i class='fa fa-trash'></i> </button>" +
                        "  </div >" +"  </div >" +
                        "</p>\n" +
                        "                                        </div>\n" +
                        "                                    </div>\n" +
                        "                                </li>";
                    $("#basic-list-group").append(html);
                }
                $('#subForm').modal('show');


                      });
                });//end show product prices

                $("#add_component").click(function (e) {
                e.preventDefault();

                    $("#add_component").html('<i class="fa fa-load"></i> ... ');
                    $.ajax({

                        data: {
                        "_token":$("input[name=_token]").val(),
                        "name":$("#component_name").val(),
                        "product_id":$("#_product_id").val()
                    },

                    url: "{{ route('store_components') }}",

                    type: "POST",

                    dataType: 'json',
                    timeout:4000,
                    success: function (data) {

                        $("#add_component").html('إضافة مكون');
                        if(data.status==200) {


                            showSuccesFunction();
                            $("#basic-list-group").html("");

                            var arrayData = data.data;
                            for (var i = 0; i < arrayData.length; i++) {
                                var html = " <li class=\"list-group-item draggable\">\n" +
                        "   <input type=\"hidden\" name=\"sort_order[]\" value='" + arrayData[i].id + "'>\n" +
                        "   <input type=\"hidden\" name=\"component_id[]\" value='" + arrayData[i].id + "'>\n" +

                        "   <div class=\"media\">\n" +
                        "\n" +
                        "  <div class=\" row media-body\">\n" + "  <div class=\" col-6\">\n" +
                        "     <h5 class=\"mt-0\"><input type='text' name='name[]' value='"+ arrayData[i].name + "' class='form-control' > </h5>" +
                        "  </div >" +"  <div class=\" col-6\">\n" +
                        
                        "<button class='btn btn-danger deleteSub' data-id='"+arrayData[i].id+"'> <i class='fa fa-trash'></i> </button>" +
                        "  </div >" +"  </div >" +
                        "</p>\n" +
                        "                                        </div>\n" +
                        "                                    </div>\n" +
                        "                                </li>";
                                $("#basic-list-group").append(html);
                                $("#component_name").val('');


                            }
                        }
                        else{
                            showErrorFunction();
                        }




                    },

                    error: function (data) {
                        $("#add_component").html('إضافة مكون');



                    }

                });
            }); // end add new price to a product


            $("#saveSortBtn").click(function (e) {
                e.preventDefault();


                $("#saveSortBtn").html('<i class="fa fa-load"></i> ... ');
                $.ajax({

                    data: $("#editFromDataSubs").serialize(),

                    url: "{{ route('Update_components') }}",

                    type: "POST",

                    dataType: 'json',
                    timeout:4000,
                    success: function (data) {

                        $("#saveSortBtn").html('حفظ الترتيب');

                        showSuccesFunction();
                            table.draw(false);
                            $("#subForm").modal('hide');

                    },

                    error: function (data) {

                        $("#saveSortBtn").html('حفظ الترتيب');

                        showErrorFunction();
                        $("#subForm").modal('hide');

                    }

                });
            }); // end add new record


            $('body').on('click', '.deleteSub', function (e) {
               e.preventDefault();
               var item =  $(this);
               var product_id = $(this).data("id");

                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({

            type: "DELETE",

            url: "{{ url('components')}}"  +"/"+ product_id,
            data:{
                '_token':'{{csrf_token()}}'
            },
            success: function (data) {
            item.parent().parent().parent().remove();
             showSuccesFunction();
            table.draw(false);

            },
            error: function (data) { }
            });   }
            });
            table.draw(false);

            });//end delete price for product


        });

    </script>

@endpush
