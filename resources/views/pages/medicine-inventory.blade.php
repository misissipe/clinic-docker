@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Medicine Inventory')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
  table,td,tr{
  border: 1px solid rgb(226, 222, 222);
  border-collapse: collapse;
  padding: 1px;
   }
   input {
   outline: 0;
   border-width: 0 0 0px;
   border-color: rgb(58, 57, 57)
   }
   </style>
   <style>
   textarea  {
     outline: 0;
   border-width: 0;
   border-color: rgb(58, 57, 57)
   }
   .ph-card-header
   {
       background-color: #3a76c5;
   }
   /* thead{
     background-color: rgb(110, 155, 222);
   } */
   ul
   {  
       cursor:pointer;  
   }  
   li:hover {
   background-color: rgba(220, 225, 229, 0.953);
  }
  .cell-border{
     border-color: rgb(138, 138, 138);
   }
   .border{
     border-color: rgb(0, 0, 0);
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}

@section('content')

<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row mx-auto">
      <div class="col-md-12">
          <div class="card">
                  <div class="card-body">
                     <table class="table table-md recordTable table-bordered " id="tableMed" style="text-align:center;">
                         <thead>
                            <tr>
                              <th style="color:black;text-align: center;border: 1px solid rgb(226, 222, 222);width:8%">Medicine Name </th>
                              <th style="color:black;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">Quantity</th>
                              <th style="color:black;text-align: center;border: 1px solid rgb(226, 222, 222);width:3%">Remaining Stock</th>
                              <th style="color:black;text-align: center;border: 1px solid rgb(226, 222, 222);width:3%">Unit of measure</th>
                              <th style="color:black;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">Expiration Date</th>
                                {{-- <th style="color:white;text-align: center">action</th> --}}
                            </tr>
                        </thead>
                        <tbody id="viewAllRecord">
                            @foreach ($data as $datas)
                            <tr>
                                 <td style="text-transform:capitalize;text-align:left">{{ $datas->item_name }}</td>
                                 <td>{{ $datas->total_stock }}</td>
                                 <td >{{ $datas->item_quantity }}</td>
                                 <td style="text-align: left;">{{ $datas->measurement }}</td>
                                 <td style="text-align: left;">{{ date('F d, Y', strtotime($datas->expiration_date)) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
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
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
  var patientId = 0;

$(document).ready(function() {
    var table = $('#tableMed').DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [{
            "targets": "_all",
            "render": function (data, type, row) {
                if (typeof data === 'string') {
                    return data.replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                }
                return data;
            }
        }]
    });
});

//Search-Input
//  $(document).ready(function() {
//   $("#submitBtn").submit(function() {
//      event.preventDefault();
//     var search = $('#searchInput').val();
//          $.ajax({
//             type:'post',
//             url:'/dental-records',
//             data:{search:search},

//             success:function(data){
//               $('#myTable').html(data);   
//             } 
//          })
//        })
//  });

// $('#saveTab').submit(function(event) {
//       event.preventDefault();  // Prevent form submission

//       var year = $('#year').val();
//       // var month = $('#month').val();

//       // Check if year and month are selected
//       if (!year) {
//         alert('Please select both year and month.');
//         return;
//       }

//       // Send AJAX request to get counts
//       $.ajax({
//         url: '/dental-total-patient',
//         method: 'POST',
//         data: {
//           year: year,
//           // month: month,
//         },
//         success: function(response) {
//           // Show the results in the #show section
//           $('#show').show();  // Make the section visible
//           $('#student-count').text(response.studentCount);
//           $('#employee-count').text(response.employeeCount);
//           $('#dependent-count').text(response.dependentCount);
//         },
//         error: function(xhr, status, error) {
//           alert('Error fetching data. Please try again.');
//         }
//       });
//     });


</script>
@endsection