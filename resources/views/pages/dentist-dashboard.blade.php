@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@php
use App\Http\Controllers\AESCipher;
@endphp 
@section('title','Dashboard')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
    border: 1px solid rgb(226, 222, 222);
 border-collapse: collapse;
 padding: 1px;
  }

  input {
  outline: 0;
  border-width: 0;
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
  .rescheduled-status {
    color: rgb(206, 187, 48); /* red */
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }
</style>
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
    <div class="row">
      <!-- Greetings Content Starts -->
      <div class="col-xl-12 col-md-6 col-12 dashboard-greetings">
        <div class="card mb-3">
          <img class="img-fluid" src="{{asset('images/logo/king2.png')}}" alt="branding logo" style="max-width: 100%; max-height: 50%">
          {{-- <div class="card-body">
            <h3 class="greeting-text">{{session('name')}}</h3> 
          </div> --}}
        </div>
      
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-body text-center">
                <h5 class="card-title text-uppercase text-muted mb-0" style="font-weight:600;">MEDICAL SERVICES</h5>
                <span class="d-block text-nowrap font-weight-bold">Total # of Student</span>
                <h2 class="font-weight-bold mb-0">{{$totalStudMS}}</h2>
                <span class="d-block text-nowrap font-weight-bold">Total # of Employee</span>
                <h2 class="font-weight-bold mb-0">{{$totalEmployeeMS}}</h2>
            </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card">
              <div class="card-body text-center">
                <h5 class="card-title text-uppercase text-muted mb-0" style="font-weight:600;">DENTAL SERVICES</h5>
                <span class="d-block text-nowrap font-weight-bold">Total # of Student</span>
                <h2 class="font-weight-bold mb-0">{{$totalStudDS}}</h2>
                <div class="row">
                  <div class="col-md-6">
                      <span class="d-block text-nowrap font-weight-bold">Total # of Employee</span>
                      <h2 class="font-weight-bold mb-0">{{$totalEmployeeDS}}</h2>
                  </div>
                  <div class="col-md-6">
                      <span class="d-block text-nowrap font-weight-bold">Total # of Dependent</span>
                      <h2 class="font-weight-bold mb-0">{{$totalDependentDS}}</h2>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-uppercase text-muted mb-0">Schedule Today</h5>
            <div class="table-responsive view-all">
              <table class="table table-sm data table-bordered table-striped" id="schedule">
                <thead>
                  <tr>
                    <th style="color:white;text-align: center">ID Number</th>
                    <th style="color:white;text-align: center">Name of Patient</th>
                    <th style="color:white;text-align: center">Purpose</th>
                    <th style="color:white;text-align: center">Date</th>
                    <th style="color:white;text-align: center">Time</th>
                    <th style="color:white;text-align: center">Create</th>
                    <th style="color:white;text-align: center">Reschedule</th>
                  </tr>
                </thead>
                <tbody id="viewAllRecord">
                  <form action="/setStatus" method="POST" id="pendingForm">
                    @csrf
                  @foreach ($appointmentToday as $data)
                  <tr>
                    <td style="text-align: center">{{ $data->patientId }}</td>
                    <td>{{ $data->lastname}}, {{ $data->firstname}} {{ $data->middlename}}</td>
                    <td>{{  implode(', ', json_decode($data->purpose)) }}</td>
                    <td style="text-align: center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                    <td style="text-align: center">{{ date('h:i A', strtotime($data->time)) }}</td>
                    <td style="text-align: center">
                      <a href="/student-dental-chart?StudentId={{ urlencode((new AESCipher)->encrypt($data->patientId)) }}" class="card-box-footer">
                          <i class="fa fa-plus"></i>
                      </a>
                  </td>
                  <td style="text-align: center">
                    <button type="button" class="btn btn-default disable-button" data-role="Student" data-id="{{ $data->id }}" data-toggle="modal" data-target="#reschedule">
                        <i class="fa fa-calendar" ></i>
                    </button>
                </td>
                  </tr>
                  @endforeach
                </form>
                </tbody>
              </table>
            </div>
            {{-- <p class="mb-0">Best seller of the month</p> --}}
          </div>
        </div>
      </div>
      @include('modal.reschedule')
    </div>
</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
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

@section('page-scripts')
<script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script>
<script>
  $.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

  $(document).ready(function() {
  $('#schedule').DataTable({
    "order": [[3, "desc"], [4, "asc"]],
    "lengthMenu": [10, 25, 50, 100]
  });
});

$("#rescheduleModal").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
            $('#rescheduleModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.success
            }).then(function() {
                location.reload();
            });
        }
    });
});

$(document).ready(function() {
    $('.approve').click(function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');

        $.ajax({
            url: "/setStatus",
            type: "POST",
            data: {
                id: id,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Success",
                        text: response.success,
                        icon: "success",
                        button: "OK"
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
        var id = $(this).data('id');
        var status = $(this).attr('value');

        Swal.fire({
            title: "Disapprove",
            text: "Please enter remarks:",
            input: 'textarea',
            showCancelButton: true,
            confirmButtonText: "Submit",
            cancelButtonText: "Cancel",
            inputValidator: function(value) {
                return new Promise(function(resolve, reject) {
                    if (value) {
                        resolve();
                    } else {
                        reject('Remarks are required.');
                    }
                });
            }
        }).then(function(remarks) {
            if (remarks.value) {
                $.ajax({
                    url: "/setStatus",
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                        stat_remarks: remarks.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Success",
                                text: response.success,
                                icon: "success",
                                button: "OK"
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
        }).catch(Swal.noop);
    });

    $('.cancel').click(function() {
        var id = $(this).data('id');
        var status = $(this).attr('value');

        $.ajax({
            url: "/setStatus",
            type: "POST",
            data: {
                id: id,
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Success",
                        text: response.success,
                        icon: "success",
                        button: "OK"
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
});

</script>
@endsection

