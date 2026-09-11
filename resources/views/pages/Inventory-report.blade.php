@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Inventory Report')

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
    <div class="col-md-2">
        <div class="card text-left">
            <div class="card-content">
                <div class="card-body">
                    <form action="/dental-total-patient" method="post" id="saveTab">
                        @csrf  
                        <div class="form-group">
                            <label for="year" style="font-size:12px; font-weight:400; color:rgb(58, 57, 57);">Year:</label>
                            <select id="year" name="year" class="form-control">
                                <option value="" selected>-Select-</option>
                                <?php 
                                    $currentYear = date('Y'); 
                                    for ($year = 2023; $year <= $currentYear; $year++) { 
                                        echo "<option value=\"$year\">$year</option>";
                                    } 
                                ?>
                            </select>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-primary submitBtn" type="submit">Search</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
        <div class="card" id="show1" style="display:none;">
            <div class="card-body">
            <h4 style="text-align:center">OVERALL</h4>
            </div>
        </div>
    </div>
    <div class="col-md-10" id="show" style="display:none;">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm recordTable table-bordered" id="recordTable" style="text-align:center;">
                    <thead>
                        <tr>
                            <th rowspan="2">Medicine</th>
                            <th colspan="12">Month</th>
                            <th rowspan="2">Yearly Total</th>
                        </tr>
                        <tr>
                            <th>January</th>
                            <th>February</th>
                            <th>March</th>
                            <th>April</th>
                            <th>May</th>
                            <th>June</th>
                            <th>July</th>
                            <th>August</th>
                            <th>September</th>
                            <th>October</th>
                            <th>November</th>
                            <th>December</th>
                        </tr>
                    </thead>
                    <tbody id="data-table">
                       
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

$(document).ready(function() {
    $('#saveTab').submit(function (e) {
        e.preventDefault(); 

        var year = $('#year').val();
 
        $('#loading').show();

        $.ajax({
            url: '/Inventory-report', 
            method: 'POST',
            data: { year: year },
            success: function(data) {
                $('#show').show(); 
                $('#show1').show(); 
                $('#loading').hide();
                updateTable(data);
            },
            error: function (error) {
                console.log('Error:', error);
                $('#loading').hide();
            }
        });
    });
    
    function updateTable(data) {
        $('#data-table').empty();
        $('#show1 .card-body').empty(); 

        const medicineNames = data.medicine_names;
        const monthlyRelease = data.monthly_release;
        let overallTotal = 0; 

        function ucwords(str) {
            return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
        }

        Object.keys(medicineNames).forEach(function (stockId) {
        const medicineName = medicineNames[stockId];
        const monthlyTotals = monthlyRelease[stockId];
        let yearlyTotal = 0;

        const monthlyData = Object.keys(monthlyTotals).map(month => {
            yearlyTotal += monthlyTotals[month];
            return `<td style="text-align:center">${monthlyTotals[month]}</td>`;
        }).join('');

        const row = `
            <tr>
                <td>${ucwords(medicineName)}</td>
                ${monthlyData}
                <td>${yearlyTotal}</td>
            </tr>
        `;

        $('#data-table').append(row);
        overallTotal += yearlyTotal; 
        });

    
        $('#show1 .card-body').append(`
            <h5 style="text-align:center">OVER-ALL TOTAL </h5>
            <h2 style="text-align:center;font-style:bold;font-weight: 700;">${overallTotal} </h2>
        `);

       
        if (!$.fn.DataTable.isDataTable('#recordTable')) {
            $('#recordTable').DataTable({
                "ordering": false
            });
        } else {
            $('#recordTable').DataTable().clear().rows.add($('#data-table').find('tr')).draw();
        }
    }
});

</script>
@endsection