@extends("admin.layout")
@section('content')

<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <p>
                        طلب تحليل
                        </p>
                        @can('اضافة طلب تحليل')
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
                                            <th> #</th>
                                            <th> اسم المريض </th>
                                            <th> اسم الاب </th>
                                            <th>  اللقب </th>
                                            <th> اسم الطبيب </th>
                                    
                                            <th>  درجة الخطورة</th>
                                            <th> حالة الطلب </th>
                                 
                                         
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
                <label class="modal-title text-text-bold-600" id="title">طلب تحليل</label>
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
                            <label>الرقم التسلسلي للمريض</label>
                            <div class="form-group">
                                <input type="text" name="patient_id" id="patient_id" placeholder="" class="form-control">
                                <input type="hidden" class="form-control" placeholder="user" id="user_id" name="user_id" value="{{Auth::user()->id}}">
                            </div><br>
                            <label>التحاليل</label>
                            <div class="form-group">
                                <select id="classification" name="classification" autocomplete="classification-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option>اختر نوع التحليل</option>
                                    @foreach($classification as $classifications)
                                    <option value="{{$classifications->id}}">{{$classifications->name}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <label>التحليل الفرعي</label>
                            <div class="form-group">
                                <select id="Subclass" name="Subclass" autocomplete="Subclass-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </select>
                                <input type="button" id="addBtn" class="btn btn-primary" value="اضافة">
                                <input type="hidden" id="selectedSubclassesInput" name="selectedSubclasses" value="">

                            </div><br>
                            <label>درجة الخطورة</label>
                            <div class="form-group">
                                <select id="condition" name="condition" autocomplete="condition-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="خطيرة">خطيرة</option>
                                    <option value="متوسطة">متوسطة</option>
                                    <option value="خفيفة">خفيف</option>
                                </select>
                            </div><br>
                            <label>حالة الطلب</label>
                            <div class="form-group">
                                <select id="state" name="state" autocomplete="state-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="تم">تم</option>
                                    <option value="غير موجود">غير موجود</option>
                                    <option value="مؤجل">مؤجل</option>
                                </select>
                            </div><br>
                        </div>
                        <div class="col-md-6">
                            <label>قائمة التحاليل الفرعية المحددة:</label>
                            <select id="subclassList" name="subclassList[]"   autocomplete="Subclass-name" multiple="multiple" class="js-example-basic-multiple mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </select>
     
                            </div><br>
                       
                         
                     
                        
                        </div>
                     
                    </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="حفظ">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--                                -->

    <!-- notes                           -->
    <div class="modal fade text-left" id="inlinenoteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="title"> ملاحظات  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>

                    </button>
                </div>
                <form action="#" method="post" id="editnoteData ">
                    @csrf
                    <input type="hidden" class="form-control"  placeholder="user" id="user_id" name="user_id" value="{{Auth::user()->id}}" >

                    <div class="modal-body">
                       <div class="row">
                           <div class="col-md-6"> 

                           
                           
                               <label>    الملاحظة  </label>
                               <input type="text" class="form-control"   id="note" name="note"  >




<br>
                    
                           
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

            ajax: "{{ route('testrequest.index') }}",

         columns: [

    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        
    {data: 'patient_id', name: 'patient_id'},
    {data: 'patientfather', name: 'patientfather'},
    {data: 'patientlastname', name: 'patientlastname'},
    {data: 'user_id', name: 'user_id'},
    {data: 'condition', name: 'condition'},
    {data: 'state', name: 'state'},


   


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
            $('#_id').val('') ;
            $('#editFromData').trigger("reset");
            $("#inlineForm").modal("show");
        });

      
 $('body').on('click', '.edit', function() {

var product_id = $(this).data('id');
$("#title").html("تعديل ");
$.get("{{ route('testrequest.index') }}" + '/' + product_id + '/edit', function(data) {
                   $("#saveBtn").val("حفظ");
                   $('#_id').val(data.id);
                   $('#user_id').val(data.user_id);
                   $('#condition').val(data.condition);
                   $('#state').val(data.state);
                   $('#patient_id').val(data.patient_id);
$("#subclassList").val(data.subclassList);
    $("#inlineForm").modal('show');

})


           }) ;// end edit function;
           
           $("#saveBtn").click(function (e) {
                e.preventDefault();

                $("#saveBtn").html('جاري الخفظ ..');
                $("#saveBtn").attr('disabled',true);
                var card_id = $("#_id").val();
                var method="post";
                var url = "{{ route('testrequest.store') }}";
                if(card_id){
                   url = "{{ route('testrequest.index') }}"+ '/' + card_id 
                   method="PATCH";
                }


    $.ajax({
        data: { formData: $('#editFromData').serialize(),
             subclassifications: requestData, },
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
                        url: "{{ route('testrequest.index') }}" + '/' + product_id,
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
    
//اضافة تحاليل ضمن الطلب
$(document).on('click', '.tests', function(e) {
    e.preventDefault();
    var product_id = $(this).data("id");
    var url =  "{{ route('addtest','id')}}";
        url = url.replace('id', product_id);
    window.location.href = url;
    
});


   
//// اضافة ملاحظة


$(document).on('click', '.note', function(e) {
    e.preventDefault();
    clickedElementId = $(this).data('id');
    $("#savenote").html("إضافة");
    $('#' + clickedElementId).val('');
    $('#editnoteData').trigger("reset");
    $("#inlinenoteForm").modal("show");
});

$("#savenote").click(function (e) {
    e.preventDefault();
    var note = $('#note').val();
    var user_id = $('#user_id').val();
    var url =  "{{ route('addnote','id')}}";
    url = url.replace('id', clickedElementId);

    $.ajax({
        url:url,
        type: "GET",
        data: {
            user_id: user_id,
            note: note,
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

$(document).ready(function() {
  $("#classification").change(function() {
    var classificationId = $(this).val();
    var url = "{{ route('getSubclass', ':classificationId') }}";
    url = url.replace(':classificationId', classificationId);

    $.ajax({
      url: url,
      method: "GET",
      success: function(data) {
        $("#Subclass").empty();
        $.each(data, function(key, value) {
          $("#Subclass").append('<option value="' + key + '">' + value + '</option>');
        });
      },
      error: function(xhr, status, error) {
        console.log(error);
      }
    });
  });

  $("#addBtn").click(function() {
  var subclassId = $("#Subclass").val();
  var subclassText = $("#Subclass option:selected").text();

  if ($("#subclassList option[value='" + subclassId + "']").length === 0) {
    $("#subclassList").append('<option selected value="' + subclassId + '">' + subclassText + '</option>');
  }
});
  $("#subclassList").on("click", ".removeBtn", function() {
    var subclassId = $(this).data("id");
    $(this).parent().remove();
    $("#Subclass option[value='" + subclassId + "']").prop("selected", false);
  });
});
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
    
</script>
@endpush