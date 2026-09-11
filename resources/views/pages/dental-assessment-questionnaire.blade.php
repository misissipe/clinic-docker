@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Health History')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
   table, td {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  text-align: center;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  .alert {
  padding: 20px;
  background-color: #ff7f76;
  color: white;
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
    
 .cert {
  outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
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
      position:absolute;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table --> 
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-8">
      <div class="card" >
        <div class="card-header">
            <table class="table" style="color:black;">
            <tr>
              <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
              </td>
            </tr>
            <tr >
              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Name:
                    <input  class="col-10 fullname cert name=" type="text" value="" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div>
                </div>
              </td>
              <td style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Age:
                    <input  class="col-7 age cert" name="age" type="text" value="" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Date of birth:
                    <input  class="col-7 bday cert" name="bday" type="text" value="" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly> 
                  </div> 
                </div>
              </td>
              <td style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Weight:
                    <input  class="col-7 weight cert" name="weight" type="text" value="" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div> 
                </div>
              </td>
              <td style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Height:
                    <input  class="col-7 height cert" name="height" type="text" value="" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div> 
                </div>
              </td>
            </tr>
            <tr>
              <td style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Blood Type:
                    <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div>  
                </div>
              </td>
              <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                    <div style="text-align: left">
                      <div style="font-weight: 400; font-size: 12px;">Allergies:
                        <input  class="col-7 allergies cert" name="allergies" type="text" value="" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                      </div> 
                    </div>
                </td>
                <td style="border:1px solid rgb(0, 0, 0);">
                  <div style="text-align: left">
                    <div style="font-weight: 400; font-size: 12px;">Medication:
                      <input  class="col-7 medication cert" name="medication" type="text" value="" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                    </div> 
                  </div>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Address:
                    <input  class="col-10 address cert" name="" type="text" value="" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                  </div> 
                </div>
              </td>
              <td style="border:1px solid rgb(0, 0, 0);">
                <div style="text-align: left">
                  <div style="font-weight: 400; font-size: 12px;">Contact No.:
                    <input  class="col-7 contactNo cert" name="" type="text" value="" id="contactNo" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly>
                  </div>
                </div>
              </td>
            </tr>
          </table>
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

  {{-- <script src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></script> --}}

<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Search-Input
 $(document).ready(function() {
  $("#submitBtn").submit(function(event) {
    event.preventDefault();
    var search = $('#searchInput').val();
         $.ajax({
            type:'post',
            url:'/add-patient',
            data:{search:search},

            success:function(data){
              $('#myTable').html(data);   
            } 
         })
       })
 });

//Hover
 document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{utf8_decode($response->FirstName)}}</b></small> <br>" +
           "<small>Middlename: <b>{{utf8_decode($response->MiddleName)}}</b></small> <br>" +
           "<small>Lastname:  <b>{{utf8_decode($response->LastName)}}</b></small>",
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

//back
 $(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
    });
 });

//Update
$("#updateForm").submit(function(e) { 
  e.preventDefault();
  var form = $(this);
  var actionUrl = form.attr('action');

  if (!$("input[name='immunization_his[]']:checked").length) {
    swal.fire({
      title: "Error",
      text: "Please select at least one Immunization History.",
      icon: "error",
      button: "OK",
    }).then(() => {
      event.preventDefault();
    });
  } else {
    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(), 
      success: function(response){
        if (response.status == 200) {
          Swal.fire({
            title: response['success'],
            icon: 'success',
            confirmButtonText: 'Okay',
          }).then((response) => {
            if (response.isConfirmed) {
              location.reload()
            }
          });
          console.log(response); 	
        }
      }
    });
  }
}); 

//Print 
document.getElementById("btnPrint").onclick = function () {
      printElement(document.getElementById("printPart"));
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

</script>
@endsection