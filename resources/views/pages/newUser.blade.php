@extends('layouts.contentLayoutMaster')
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Add User')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page-styles --}}

@section('content')
{{-- <div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div> --}}
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">USERS</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">+ Add</button>
                        <div class="table-responsive">
                            <table class="table zero-configuration" >
                                <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach($user as $data)
                                        <tr>    
                                        <td>{{$data->lastname}}</td>
                                        <td>{{$data->firstname}}</td>
                                        <td>{{$data->middlename}}</td>
                                        <td>{{$data->role}}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary viewModal" data-id="{{"$data->lastname"}}" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-edit" style="font-size:20px"></i></button>
                                          
                                        </td>           
                                        </tr>
                                    @endforeach
                                    </tr>
                            </table>
                            @include('modal.addUser')
                            @include('modal.viewUser')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>

$("#updateForm").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), 
                success: function(data)
                {
                    $('#addUserModal').modal('hide')
                    alert(data.success)
                  location.reload();					
                }
            });
        });

$(document).on('click', '.viewModal', function(){
  
    $.ajax({
        url: '/viewUser',
        type: 'post',
        data:  {employee_id: $(this).data('id')},
        success: function(response) {
         console.log();
        }
    });
});

</script>
@endsection