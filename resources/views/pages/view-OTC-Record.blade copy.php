@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Over-The-Counter Medicine')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
 border: 1px solid rgb(58, 57, 57);
 border-collapse: collapse;
 padding: 1px;
  }
  input {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  textarea  {
    outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  .ph-card-header
  {
      background-color: #3a76c5;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 16px; 
    color: #000000;
    cursor: pointer;
  }
</style>
<style>
  @media screen {
    #printSection {
        display: none;
    }
  }
  @media print {
    body * {
      visibility:hidden;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    .printed-div{
  position: absolute;
  left: 120px;
    }
   
    #printSection, #printSection * {
      visibility:visible;
    }
    #printSection {
      position:relative;
      left:0;
      top:0;
    }
  }
  @page {
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
 }
</style>
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
        {{-- <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>TODAY</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class=" col-md-12">
                            <label for="role" style="display: inline-block;font-size:15px">VIEW SCHEDULE:</label>
                            <select name="role" class="form-control col-sm-2" style="display: inline-block;">
                            <option value="disable selected">-Select-</option>
                            <?php
                            $patient = array("Today", "Pending (today)",'All');
                            foreach ($patient as $pa) {
                                echo "<option value=\"$pa\">$pa</option>";
                            }
                            ?>
                            </select>
                           <button type="button" id="generate" class="btn btn-primary">generate</button>
                        </div>
                    </div> 
                </div>
            </div>
        </div> --}}
        <div class="col-12" style="display : none">
          <div class="card-content">
            <div class="card active" id="today">
              <div id="printThis">
                <div class="col-12  d-flex justify-content-center" >
                  <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 300px; height: 100px;margin-right:30px">
                  <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 80px; height: 80px;">
                </div>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
              </div>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">Over-The-Counter</div>
              </div>
                <div class="card-content">
                <div class="card-body">
                    <form action="/setStatus" method="POST" id="pendingForm">
                        @csrf
                    <div class="table-responsive view-all">
                        <table class="table  table-bordered table-striped" id="">
                            <thead>
                              <tr>
                                <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Date</th>
                                <th style="background-color:rgb(255, 249, 249);color:black;text-align:center">Name</th>
                                <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Remarks</th>
                                <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Medicine</th>
                                {{-- <th style="color:white;">Approve</th> --}}
                                {{-- <th style="color:white;">Disapprove</th> --}}
                              </tr>
                            </thead>
                            <tbody id="viewAllRecord">
                              @foreach ($datas as $data)
                              <tr>
                                <td > {{date('m-d-Y', strtotime($data->date))}}</td>
                                <td>{{ utf8_decode($data->firstname) }} {{ utf8_decode($data->middlename) }} {{ utf8_decode($data->lastname) }}</td>
                                <td>{{ $data->OTCremarks }}</td>
                                <td>
                                  @php
                                    $otcmedpcs = json_decode($data->OTCmedpcs);
                                    $otcmedDescript = json_decode($data->OTCmedDescript);
                                    $combinedValues = [];

                                    foreach ($otcmedpcs as $index => $otcmedpc) {
                                      if (strlen($otcmedDescript[$index]) > 1) {
                                        $combinedValues[] = $otcmedpc . ' - ' . $otcmedDescript[$index]. '<br>';
                                      } else {
                                        $combinedValues[] = $otcmedpc ;
                                      }
                                    }
                                    echo implode('', $combinedValues);
                                  @endphp
                                </td>                                         
                                {{-- <td><button type="button" class="btn btn-default approve disable-button" data-role="Student" data-id="{{ $data->id }}"><i class="fa fa-thumbs-up" style="color: rgb(79, 198, 79)"></i></i></button></td>
                                <td><button type="button" class="btn btn-default disapprove disable-button" data-role="Student" data-id="{{ $data->id }}"><i class="fa fa-thumbs-down" style="color: rgb(198, 101, 79)"></i></i></button></td> --}}
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                         </div>
                      </div>  
                </div> 
              </div>
          </div>
        </div>
      </div>
        <div class="col-12">
          <div class="card-content">
            <div class="card active" id="today">
                <div class="card-content">
                <div class="card-body">
                  <div class="">
                    <button id="btnPrint" class="btn btn-primary">Print</button>
                  </div>
                    <form action="/setStatus" method="POST" id="pendingForm">
                        @csrf
                    <div class="table-responsive view-all">
                        <table class="table table-sm recordTable table-bordered table-striped" id="recordTable">
                            <thead>
                              <tr>
                                <th style="color:white;text-align:center">Action</th>
                                <th style="color:white;text-align:center">Date</th>
                                <th style="color:white;text-align:center">Name</th>
                                <th style="color:white;text-align:center">Remarks</th>
                                <th style="color:white;text-align:center">Medicine</th>
                                {{-- <th style="color:white;text-align:center">Action</th> --}}
                                {{-- <th style="color:white;">Disapprove</th> --}}
                              </tr>
                            </thead>
                            <tbody id="viewAllRecord">
                              @foreach ($datas as $data)
                              <tr>
                                <td style="text-align:center">
                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item viewbutton" href="#" data-role="Student" data-id="{{ $data->id }}"><i class="bx bx-edit mr-1"></i>edit</a>
                                        <a class="dropdown-item deleteButton" href="#"  data-role="Student" data-id="{{ $data->id }}"><i class="bx bx-trash mr-1"></i>delete</a>
                                    </div>
                                    </div>
                                </td>
                                <td style="text-align: center"> {{date('m-d-Y', strtotime($data->date))}}</td>
                                <td>{{ utf8_decode($data->firstname) }} {{ utf8_decode($data->middlename) }} {{ utf8_decode($data->lastname) }}</td>
                                <td>{{ $data->OTCremarks }}</td>
                                <td>
                                  @php
                                    $otcmedpcs = json_decode($data->OTCmedpcs);
                                    $otcmedDescript = json_decode($data->OTCmedDescript);
                                    $combinedValues = [];

                                    foreach ($otcmedpcs as $index => $otcmedpc) {
                                      if (strlen($otcmedDescript[$index]) > 1) {
                                        $combinedValues[] = $otcmedpc . ' - ' . $otcmedDescript[$index]. '<br>';
                                      } else {
                                        $combinedValues[] = $otcmedpc ;
                                      }
                                    }

                                    echo implode('', $combinedValues);
                                  @endphp
                                </td>                                         
                                {{-- <td><button type="button" class="btn btn-default deleteButton disable-button" data-role="Student" data-id="{{ $data->id }}"><i class="fa fa-trash-o" style="font-size:15px;color:red"></i></i></button></td> --}}
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                          <button type="button"  id="backBtn" class="col-sm-1 btn btn-secondary  float-right">Back</button>
                         </div>
                    </form>
                      </div>  
                </div> 
          </div>
          @include('modal.OTC-edit')
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {
    $('#recordTable').DataTable({
      "order": [[0, "desc"]],
      // dom: 'Bfrtip',
      //   buttons: [
      //       'copy', 'csv', 'excel', 'pdf', 'print'
      //   ]
    });
  });

  $(document).ready(function() {
    $('#data').DataTable({
      "order": [[2, "asc"]],
      "lengthMenu": [5, 10, 25, 50,100]
    });
  });

  $(document).ready(function() {
    $('#record').DataTable({                  
      "order": [[0, "desc"]],
      "lengthMenu": [5, 10, 25, 50,100]
    });
  });

//Cancel button in Add
$(document).ready(function(){
    $("#backBtn").click(function(){
      window.location.href = "/patient-OTC-record";
  })
 });


//Print Document
document.getElementById("btnPrint").onclick = function () {
      printElement(document.getElementById("printThis"));
  }

  function printElement(elem) {
      var domClone = elem.cloneNode(true);
      
      var $printSection = document.getElementById("printSection");
      
      if (!$printSection) {
          var $printSection = document.createElement("div");
          $printSection.id = "printSection";
          document.body.appendChild($printSection);
      }
      
      $printSection.innerHTML = "";
      $printSection.appendChild(domClone);
      window.print();
  }

//View Modal
$(document).ready(function () {
    $('.viewbutton').click(function () {
        var id = $(this).data('id');
                          
        $.ajax({
            type: "POST",
            url: "/viewModalOTC",
            data: { id: id },
            dataType: "json",
            success: function (response) {
                var jsonString = response.OTCmedpcs;
                var jsonString1 = response.OTCmedDescript;
                var pcsValue = JSON.parse(jsonString);
                var descriptValue = JSON.parse(jsonString1);
                var today = new Date();
                var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

  
                $('.input-group').empty();

                for (var i = 0; i < pcsValue.length; i++) {
                    var inputGroup = $('<div class="input-group"></div>');
                    var pcsInput = $('<input type="number" class="form-control col-sm-1" style="display: inline-block;" id="OTCmedpcs" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs." value="">').val(pcsValue[i]);
                    var descriptionInput = $('<input type="text" class="form-control col-sm-4" style="display: inline-block;" id="OTCmedDescript" name="OTCmedDescript[]" aria-describedby="" placeholder="description" value="">').val(descriptValue[i]);
                    
                 
                    var removeButton = $('<button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>');
                  
                    removeButton.click((function(inputGroup) {
                        return function() {
                            inputGroup.remove();
                        };
                    })(inputGroup));
                    
                    inputGroup.append(pcsInput).append(descriptionInput).append(removeButton);
                    $('.modal-body').append(inputGroup);
                }

                $('#id').val(response.id);
                $('#viewDate').val(formattedDate);
                $('#OTCremarks').val(response.OTCremarks);

                $('#OTCEdit').modal('show');
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });
});

 //Delete
 $(document).ready(function() {
    $('.deleteButton').click(function() {
        var recordId = $(this).data('id');

        Swal.fire({
            title: 'Delete Record',
            text: 'Are you sure you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#d33',
        }).then((result) => {
          if (result.isConfirmed) {

          $.ajax({
              type: 'POST',
              data: { id: recordId}, 
              url: '/deleteRecord-OTC',
              success: function(response) {
                if (response.message === 'Deleted successfully') {
                Swal.fire({
                  title: 'Deleted!',
                  text: 'The record has been deleted.',
                  icon: 'success',
                  confirmButtonText: 'OK'
                }).then((result) => {
          
                  if (result.isConfirmed || result.isDismissed) {
                      location.reload();
                  }
                });
                } else {
                    Swal.fire('Error!', 'Failed to delete the record.', 'error');
                }
              },
              error: function() {
                  Swal.fire('Error!', 'Failed to delete the record.', 'error');
              }
          });
          }
      });
    });
});





// $(document).ready(function() {
//     $('#updateOTCModal').submit(function(e) {
//         e.preventDefault();

//         $.ajax({
//             type: 'POST',
//             url: '/new-update-OTC-medicine',
//             data: $(this).serialize(),
//             success: function(response) {
//                 console.log(response);
//                 // Handle success, maybe close the modal or show a success message
//             },
//             error: function(error) {
//                 console.error(error);
//                 // Handle error, maybe show an error message
//             }
//         });
//     });
// });


$(document).ready(function() {
  $("#add-input").click(function() {
    var inputGroup = `
    
      <div class="input-group">
        <input type="number" class="form-control col-sm-1" style="display: inline-block;" id="" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs.">
        <input type="text" class="form-control col-sm-4" style="display: inline-block;" id="" name="OTCmedDescript[]" aria-describedby="" placeholder="description">
        <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
      </div>
    `;
    $("#inputs-container").append(inputGroup);
  });


  $(document).on("click", ".remove-input", function() {
    $(this).parent().remove();
  });
});

$(document).ready(function() {
    $("#addNewinput").click(function() {
      var inputGroup = `
        <div class="input-group">
          <br><br>
          <input type="number" class="form-control col-sm-1" style="display: inline-block;" id="newInputPcs" name="OTCmedpcs[]" aria-describedby="" placeholder="pcs.">
          <input type="text" class="form-control col-sm-4" style="display: inline-block;" id="newInputDescript" name="OTCmedDescript[]" aria-describedby="" placeholder="description">
          <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
        </div>
      `;
      $("#input-addition").append(inputGroup);
    });

    $("#submitBtn").click(function() {
        var form = $("#updateOTCModal");
        var formData = form.serializeArray();
        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            success: function(response) {
          if (response.status == 200) {
             Swal.fire({
             title: response['success'],
             icon: 'success',
             confirmButtonText: 'Okay',
          }).then((response) => {
              
          if (response.isConfirmed) {
            $('#OTCEdit').modal('hide')
              console.log(response); 
              location.reload();			
          }
        })
      }
        },
         error: function(xhr, status, error) {
            }
        });
    });
});


</script>
@endsection