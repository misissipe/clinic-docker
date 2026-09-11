 
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
<style>
   table,td,tr{
  border: 1px solid rgb(226, 222, 222);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;
  }

    .container {
      display: flex;
      justify-content: space-between;
    }

    td.a{
      text-align: right;
      vertical-align: bottom;
      }

    input {
      outline: 0;
      border-width: 0 0 1px;
      border-color: rgb(58, 57, 57);
    }
  .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57);
    
    }
  .textbox {
    transform: scale(1.5);
    margin: 4px;
    accent-color: rgb(58, 57, 57);
    width: 50px;
  }
  textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
    
    }
  label {
    text-transform: lowercase;
  }

  label::first-letter {
    text-transform: uppercase;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  br.break {
  display: block;
  margin-bottom: 1px;
  line-height: 1px;
 } 
 .cell-border{
    border-color: rgb(80, 80, 80)
  }
  ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
  }

  .zero-configuration td:nth-child(3):contains('pending') {
      background-color: rgb(121, 144, 221);
  }
  .pending-status {
    color: rgb(99, 175, 211); /* light blue */
    text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); /* green */
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }

  .disapproved-status {
    color: rgb(211, 99, 99); /* red */
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }
</style>
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row mx-auto">
    <div class="col-md-2">
      <div class="card text-left">
        <div class="card-body">
          <div class="form-group">
            <div class="col-sm-12">
              <div style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                Choose role:
                <select id="roleSelect" class="form-control" aria-label="Default select example">
                    <option selected>-Select Role-</option>
                    <option value="Student">Student</option>
                    <option value="Employee">Employee</option>
                </select>
              </div><br>
              <div  style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);" >    
                Search:
                <input class="form-control" type="text"  id="query"  placeholder="Type here..." >
                <ul id="results" class="list-group"  style="display: none;font-size:12px;font-weight:400; "></ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-10" id="show" style="display : none" >
      <div class="card text-left">
        <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;display:flex;align-items:center;">
          <i class="fa fa-id-card-o" style="font-size:30px"></i>
          <input type="text" class="cert col-sm-10" name="firstname" id="fullname" style="background-color:transparent;color:#ffffff;font-size:19px;font-weight:500" readonly>
        </div>        
        <div class="card-body">
          <input type="text" class="id" name="patientId" id="id" placeholder="id" hidden >
          <div class="table-responsive view-all">
            <table class="table recordTable cell-border table-sm zero-configuration" id="recordTable">
              <thead>
                <tr>
                  <th style="color:white;">Date</th>
                  <th style="color:white;">Issued For</th>
                  <th style="color:white;">Status</th>  
                  <th style="color:white;">Action</th>
                </tr>
              </thead>
            </table>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
  var patientId = 0;
//Search-Input
 $(document).ready(function() {
  $("#submitBtn").submit(function() {
     event.preventDefault();
    var search = $('#searchInput').val();
         $.ajax({
            type:'post',
            url:'/patient-medical-record',
            data:{search:search},

            success:function(data){
              $('#myTable').html(data);   
            } 
         })
       })
 });


// print
$(document).on('click', '.view', function(){
  var id = $(this).data('id'); 
  var role = $('#roleSelect').val();
    console.log(role);
    console.log(id);

  if (role === 'Student') {
    window.location.href = "/viewGeneratedCert?id=" + encodeURIComponent(id)  + "&role=Student";
  } else if (role === 'Employee') {
    window.location.href = "/viewGeneratedCert?id=" + encodeURIComponent(id)  + "&role=Employee";
  }
 });

//Cancel button in Add
 $(document).ready(function(){
    $("#cancelBtn").click(function(){
      location.reload();
  })
 });

//Search
 $(document).ready(function() {
      $('#query').keyup(function () {
            var query = $(this).val();
            var role = $('#roleSelect').val();

            if (role === 'Student' || role === 'Employee') {
                if (query !== '') {
                    $.ajax({
                        url: "{{ route('autocomplete') }}",
                        method: "post",
                        data: {role: role, query: query},
                        dataType: "json",
                        success: function (data) {
                            $('#results').fadeIn();
                            $('#results').html('');

                            $.each(data, function (index, item) {
                                if (role === 'Student') {
                                    $('#results').append('<li class="list-group-item" data-id="' + item.StudentNo + '" data-last_name="' + item.LastName + '" data-first_name="' + item.FirstName + '" data-middle_name="' + item.MiddleName + '">' + item.StudentNo + '-' + item.LastName + ', ' + item.FirstName + ' ' + item.MiddleName + '</li>');
                                } else if (role === 'Employee') {
                                    $('#results').append('<li class="list-group-item" data-id="' + item.empNo + '" data-lastname="' + item.lastname + '" data-firstname="' + item.firstname + '" data-middlename="' + item.middlename + '">' + item.empNo + '-' + item.lastname + ', ' + item.firstname + ' ' + item.middlename + '</li>');
                                }
                            });
                        }
                    });
                } else {
                    $('#results').fadeOut();
                }
            } else {
                $('#results').fadeOut();
            }
        });

        $('#results').on('click', 'li', function() {
        var patientId = $(this).data('id');
        var today = new Date();
        var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
        $('#query').val(patientId);
        $('#results').fadeOut();

        $.ajax({
            url: "{{ route('result') }}",
            method: "post",
            data: { patientId: patientId},
            dataType: "json",
            success: function(data) {
        var table = $('.zero-configuration').DataTable();
        if (data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No records found.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                location.reload();
            });
            return;
        }
      $.each(data, function(index, row) {

              var dateArr = row.date.split('-');
              var year = dateArr[0];
              var month = dateArr[1];
              var day = dateArr[2];
              var newDateStr = month + '/' + day + '/' + year;
              var jsonString = row.cert_issued;
              var cert_issued = JSON.parse(jsonString);
                
              $('#fullname').val([row.firstname] + ' ' + [row.middlename] + ' ' + [row.lastname]);
                var statusClass = '';
                  if (row.status === 'Pending') {
                    statusClass = 'pending-status';
                  } else if (row.status === 'Approved') {
                    statusClass = 'approved-status';
                  } else if (row.status === 'Disapproved') {
                    statusClass = 'disapproved-status';
                  }

                  if (cert_issued.includes("Others")) {
                    cert_issued = row.others;
                  }

                  if (row.status === 'Pending'){
                    table.row.add([
                    newDateStr,
                    cert_issued,
                    '<span class="' + statusClass + '">' + row.status + '</span>',
                    '<button type="button" class="btn btn-default view" data-id="' + row.id + '"' + (row.status === "approved" ? "disabled" : "") + '><i class="fa fa-file"></i></button>'
                  ])
                }
              });
              table.draw();

              table.$('tr').addClass('tr');

              $("#show").removeAttr("style").hide();
              $("#show").show();
            }
        }) 

    $('#query').on('input', function() {
        if ($(this).val() == '') {
            $("#show").hide();
            table.clear();
        }
      });
    });
  });

//
$(document).ready(function() {
    $('.approve').click(function() {
        var id = $('#id').val();
        var status = $(this).val();

        $.ajax({
            url: "/approve-result",
            type: "POST",
            data: {
                id: id,
                status: status,
            },
            success: function(response) {
                if (response.success) {
                    swal.fire({
                        title: "Success",
                        text: response.success,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                location.reload();
            });
                } else if (response.error) {
                    alert(response.error);
                }
            },
            error: function(xhr) {
                alert("An error occurred: " + xhr.status + " " + xhr.statusText);
            }
        });
    });

    $('.disapprove').click(function() {
    var id = $('#id').val();
    var status = $(this).val();

    swal.fire({
        title: "Disapprove",
        text: "Please enter remarks:",
        input: 'textarea',
        showCancelButton: true,
        confirmButtonText: "Submit",
        cancelButtonText: "Cancel",
        inputValidator: function (value) {
            return new Promise(function (resolve, reject) {
                if (value) {
                    resolve();
                } else {
                    reject('Remarks are required.');
                }
            });
        }
    }).then(function (remarks) {
        if (remarks.value) {
            $.ajax({
                url: "/approve-result",
                type: "POST",
                data: {
                    id: id,
                    status: status,
                    stat_remarks: remarks.value,
                },
                success: function(response) {
                    if (response.success) {
                        swal.fire({
                            title: "Success",
                            text: response.success,
                            icon: "success",
                            button: "OK",
                        }).then(() => {
                location.reload();
            });
                       
                    } else if (response.error) {
                        alert(response.error);
                    }
                },
                error: function(xhr) {
                    alert("An error occurred: " + xhr.status + " " + xhr.statusText);
                }
            });
        }
    }).catch(swal.noop);
  });
});

</script>
@endsection