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
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;height:50px; display:flex;align-items:center"><i class="fas fa-file-alt " style='font-size:15px;'></i> PATIENT RECORD</div>
              <div class="card-body mt-0 p-1">
                {{-- <form action="/generate-pdf" method="get" target="_blank" class="float-right">
                  <input type="hidden" name="StudentId" value="{{ $data->StudentNo }}">
                  <button type="submit" class="btn btn-primary" style="font-size: 15px; color: rgb(255, 255, 255);"> Print</button>
                </form> --}}
               <div class="table-responsive view-all">
                <table class="table table-sm table-bordered table-striped zero-configuration" id="">
                  <thead>
                    <tr>
                      <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Date</th>
                      <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Remarks</th>
                      <th style="background-color:rgb(255, 255, 255);color:black;text-align:center">Medicine</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                    @foreach ($view as $data)
                    <tr>
                      <td > {{date('m-d-Y', strtotime($data->date))}}</td>
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
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button"  id="backBtn" class="btn btn-secondary  float-right">Back</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card">
        <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
            @if ($data->gender === 'F' || $data->gender === 'Female')
            <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @elseif ($data->gender === 'M' || $data->gender === 'Male')
            <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @endif
        </div> 
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
          <label style="font-size: 18px;" id="id">{{$data->patientId}}</label>
          <label class="inline-cursor" id="firstname">{{utf8_decode($data->firstname)}}</label>
        </div>
      </div>                
    </div>
</div>
     @if (session('error'))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
               <script>
                   Swal.fire({
                       icon: 'error',
                       title: '{{ session("error")}}'
                   });
               </script>
           @endif  
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

 document.getElementById("firstname").addEventListener("mouseenter", function() {
      Swal.fire({
        title: "<small>Firstname: <b>{{utf8_decode($data->firstname)}}</b></small> <br>" +
              "<small>Middlename: <b>{{utf8_decode($data->middlename)}}</b></small> <br>" +
              "<small>Lastname:  <b>{{utf8_decode($data->lastname)}}</b></small>",
        icon: "info",
        showConfirmButton: false,
        allowOutsideClick: true,
        allowEscapeKey: true,
        timerProgressBar: true,
        toast: true,
        position: "top-end"
      });
    });

    document.getElementById("firstname").addEventListener("mouseleave", function() {
      Swal.close();
});

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