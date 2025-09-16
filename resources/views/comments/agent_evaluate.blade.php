@extends("admin.layout")
@section('content')


<section id="input-style">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                    <p>
                        تقييم العملاء
                    </p><br>

                        <div class="row">
                            <div class="col-sm-12" style="overflow-x:auto;">
                                <table id="tableData" class="table table-striped table-sm data-table">
                                    <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> العميل </th>
                                        <th> رقم العميل </th>
                                        <th> عدد الطلبات المنجزة </th>
                                        <th >عدد التعليقات </th>
                                        <th >التعليقات   </th>
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





    

@endsection


@push('pageJs')

    <script type="text/javascript">

        $(function () {


            var table = $('.data-table').DataTable({

                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

            ajax: "{{ route('agent_evaluate') }}",

            columns: [

                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'user1'},
                {data: 'phone_number', name: 'user2'},
                {data: 'orderSum', name: 'orderSum'},
                {data: 'commentSum', name: 'commentSum'},
                {data: 'all', name: 'all'},
                {data: 'action', name: 'action', orderable: false, searchable: false},

]

});

        

            $('body').on('click', '.delete', function () {
                var product_id = $(this).data("id");
                sweetConfirm( function (confirmed) {
                if (confirmed) {
                    $.ajax({
            type: "DELETE",
            url: "{{ route('agent_evaluate') }}"+ '/' + product_id ,
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
