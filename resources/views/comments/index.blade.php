@extends("admin.layout")
@section('content')


<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                    <p>
                         تعليقات  
                            {{$user1->name}}
                    </p><br>

                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> المعلق </th>
                                        <th> التعليق </th>
                                        <th >العمليات </th>

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
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
    <div class="modal-header">
        <label class="modal-title text-text-bold-600" id="myModalLabel33">   التعليقات   </label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-close"></i></span>
        </button>
    </div>
                <form action="#" method="post" id="editFromData" >
                    @csrf
                    <input type="hidden" name="_id" id="_id">
                    <div class="modal-body">
                        <div class="row">
                           
                                <div class="col-md-10">
                                 <label> التعليق </label>
                                <div class="form-group">
                                    <textarea rows="6" cols="50" class="form-control" name="comment" id="comment"></textarea>

                                </div>

                            </div>
                            <div class="col-md-8" id="offer_products">

                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">
                        <input type="submit" name="saveBtn" id="saveBtn" class="btn btn-primary" value="حفظ">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- print forms -->


@endsection


@push('pageJs')

    <script type="text/javascript">

        $(function () {


            var table = $('.data-table').DataTable({

                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{ url('comment')}}"+'/'+ {{$user1->id}},
         

                columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user2.name', name: 'user2'},
                {data: 'comment', name: 'comment'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

]

});

                $('body').on('click', '.show', function () {
                var product_id = $(this).data('id');
                $.get("{{ url('comment') }}" + '/' + product_id + '/edit', function (data) {
                    $("#saveBtn").val("حفظ");
                    $('#_id').val(data.id);
                    $('#comment').val(data.comment);
                    $("#inlineForm").modal('show');
                })
            })

            // fill select delegate


            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "DELETE",
            url: "{{ url('comment') }}"+ '/' + product_id + '/delete',
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
               

            }) ;// end delete function;




});



    </script>

@endpush
