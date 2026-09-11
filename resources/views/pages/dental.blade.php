@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Management Information System')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .table {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  text-align: center;
  }
  .x-cell::before {
  content: "✕";
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  }
  .border {
    border: 1px;
    color:rgb(58, 57, 57)
  }
  .align{
      text-align: center;
  }
  .move{
      text-align: left;
  }
  input {
        outline: 0;
        border-width: 0;
        border-color: rgb(58, 57, 57);
      }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
  }
  .textbox {
      transform: scale(1.5);
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
 }
 .head{
  background-color:rgba(110, 155, 222, 0);
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
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="card border">
              <div class="card-header">
                  <div class="table-responsive">
                    <div class="card-header" style="text-align: center">
                      <h4>DENTAL RECORD CHART</h4>
                    </div>
                    <div class="col-sm-12">
                      <h4>INTRAORAL EXAMINATION</h4>
                      <div class="row col-12" style="font-size:17px;font-weight:400;font-weight: bold;">
                        Name:
                        <input type="text" class=" col-sm-7 border-0 fullname" name=""  id="fullname" style="font-weight:400;font-weight: bold;" value="{{$record->first_name}} {{$record->middle_name}} {{$record->last_name}}" readonly>&emsp;&emsp;&emsp;&emsp;
                        DoB:
                        <input type="text" class=" col-sm-3 border-0 bday" name=""  id="bday" style="font-weight:400;font-weight: bold;" value="{{ date('m-d-Y', strtotime($record->BirthDate)) }}" readonly>
                      </div>
                      <div class="row col-12" style="font-size:17px;font-weight:400;font-weight: bold;">
                        Home Address:
                        <input type="text" class=" col-sm-7 border-0 address" name=""  id="address" style="font-weight:400;font-weight: bold;" value="{{$record->brgy}}, {{$record->city}}, {{$record->province}}" readonly>
                        Age:
                        <input type="text" class=" col-sm-2 border-0 age" name=""  id="age" style="font-weight:400;font-weight: bold;" value={{$record->age}} readonly>
                      </div>
                    </div>
                  <br><br><br><br>
                  <div class="" style="text-align: center">
                    <h5>DENTITION STATUS AND TREATMENT NEEDS</h5>
                  </div>
                  <div class="col-12 align" >
                   
                  <table class="" style="margin:auto;">
                      <thead class="head">
                          <tr>
                          <td colspan="3"  style="border:none"> Status</td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="55"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="54"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="53"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="52"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="51"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="61"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="62"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="63"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="64"></button></td>
                          <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary  viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="65"></button></td>
                          <td colspan="3"  style="border:none"></td>
                         </tr>
                          <tr>
                              <td colspan="3"  style="border:none;"> Right</td>
                              <td class="border">55</td>
                              <td class="border">54</td>
                              <td class="border">53</td>
                              <td class="border">52</td>
                              <td class="border">51</td>
                              <td class="border">61</td>
                              <td class="border">62</td>
                              <td class="border">63</td>
                              <td class="border">64</td>
                              <td class="border">65</td>
                              <td colspan="3"  style="border:none"> Left</td>
                          </tr>
                          <tr>
                              <td colspan="3" style="border:none">Temporary Teeth</td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td colspan="3"  style="border:none"></td>
                          </tr>
                          <tr>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="18"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="17"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="16"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="15"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="14"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="13"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="12"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="11"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="21"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="22"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="23"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="24"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="25"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="25"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="27"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="28"></button></td>
                          </tr>
                          <tr>
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>                              
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>
                          </tr>
                          <tr>
                              <td class="border">18</td>
                              <td class="border">17</td>
                              <td class="border">16</td>
                              <td class="border">15</td>
                              <td class="border">14</td>
                              <td class="border">13 </td>
                              <td class="border">12</td>
                              <td class="border">11</td>
                              <td class="border">21</td>
                              <td class="border">22</td>
                              <td class="border">23 </td>
                              <td class="border">24</td>
                              <td class="border">25</td>
                              <td class="border">26</td>
                              <td class="border">27 </td>
                              <td class="border">28</td>
                          </tr>
                          <tr>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                          </tr>
                          <tr>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                          </tr>
                          <tr>
                              <td class="border">48 </td>
                              <td class="border">47 </td>
                              <td class="border">46</td>
                              <td class="border">45</td>
                              <td class="border">44</td>
                              <td class="border">43</td>
                              <td class="border">42</td>
                              <td class="border">41</td>
                              <td class="border">31</td>
                              <td class="border">32</td>
                              <td class="border">33</td>
                              <td class="border">34</td>
                              <td class="border">35</td>
                              <td class="border">36</td>
                              <td class="border">37</td>
                              <td class="border">38</td>
                          </tr>
                          <tr>
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>                              
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>  
                              <td class="border" style="width: 50px;"><input type="text" class="" style="width: 100%;"></td>   
                          </tr>
                          <tr>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="48"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="47"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="46"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="45"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="44"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="43"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="42"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="41"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="31"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="32"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="33"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="34"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="35"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="36"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="37"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="38"></button></td>
                          </tr>
                          <tr>
                              <td colspan="3" style="border:none">Temporary Teeth</td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td class="x-cell border"></td>
                              <td colspan="3"  style="border:none"></td>
                          </tr>
                          <tr>
                              <td colspan="3"  style="border:none">Right</td>
                              <td class="border">85</td>
                              <td class="border">84</td>
                              <td class="border">83</td>
                              <td class="border">82</td>
                              <td class="border">81</td>
                              <td class="border">71</td>
                              <td class="border">72</td>
                              <td class="border">73 </td>
                              <td class="border">74</td>
                              <td class="border">75</td>
                              <td colspan="3"  style="border:none">Left</td>
                          </tr>
                          <tr>
                              <td colspan="3"  style="border:none">Status</td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="85"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="84"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="83"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="82"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="81"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="71"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="72"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="73"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="74"></button></td>
                              <td class="border" style="width: 30px; height: 30px;"><button type="button" class="btn btn-secondary viewModal" style="width: 100%; height: 100%; border-radius: 0;" patientId={{$record->id}} toothId="75"></button></td>
                          <td colspan="3"  style="border:none"></td>
                             </tr>
                      </thead>
                  </table>
                  @include('modal.Treatment-Record')
                  <br><br><br>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
                <label for="cancer" style="text-transform: capitalize;font-size:18px;font-weight:bolder">Legend:</label><br>
                <div class="row " >
                <div class=" mx-auto ">
                  <div class=" form-group" >
                  <br>
                    <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Condition</label><br>
                    <label for="cancer" style="text-transform: capitalize;font-size:12px">D- Decayed (caries indicated for filing)</label><br>                
                    <label for="heart" style="text-transform: capitalize;font-size:12px">M- Missing</label><br>    
                    <label for="hypertension" style="text-transform: capitalize;font-size:12px">F- Filled</label><br>                      
                    <label for="thyroid" style="text-transform: capitalize;font-size:12px">I- Caries indicated for Extration</label><br>                       
                    <label for="tuberculosis" style="text-transform: capitalize;font-size:12px">RF- Root Fragment</label><br>                  
                    <label for="thyroid" style="text-transform: capitalize;font-size:12px">MO- Missing due to Other Causes</label><br>                      
                    <label for="tuberculosis" style="text-transform: capitalize;font-size:12px">Im- Impacted Tooth</label><br>
                  </div>
                </div>
                <div class=" mx-auto">
                  <div class="form-group">
                    <br>
                    <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Restoration & Prosthetics</label><br>
                    <label for="diabetes" style="text-transform: capitalize;font-size:12px">J- Jacket Crown</label><br>                        
                    <label for="mental" style="text-transform: capitalize;font-size:12px">A- Amalgam Filling</label><br>                       
                    <label for="asthma" style="text-transform: capitalize;font-size:12px">AB- Abutment</label><br>                       
                    <label for="convulsion" style="text-transform: capitalize;font-size:12px">P- Pontic</label><br>                       
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">In- inlay</label><br>                       
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">Fx- Fixed Cure Composite</label><br>                       
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">S- Sealant</label><br>                        
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">Rm- Removable Denture</label><br>
                  </div>
                </div>
                </div>
              <div class="row " >
                <div class=" mx-auto">
                  <div class="form-group">
                      <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Surgery</label><br>
                      <label for="vehiceyele1" style="text-transform: capitalize;font-size:12px">X- Extraction due to Causes</label><br>
                      <label for="skin" style="text-transform: capitalize;font-size:12px">XO- Extraction due to Other Causes</label><br>
                  </div>
                </div>
                <div class=" mx-auto">
                  <div class="form-group">
                      <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Others</label><br>
                      <label for="gastrointestinal" style="text-transform: capitalize;font-size:12px">C- Present Teeth</label><br>
                      <label for="vehicle2" style="text-transform: capitalize;font-size:12px">Cm- Congenitally Missing</label><br>
                      <label for="vehicle2" style="text-transform: capitalize;font-size:12px">Sp- Supernumerary</label><br>
                  </div>
                </div>
            </div>
            <hr>
            <div class="row" >
                <div class=" mx-auto">
                  <div class="form-group">
                    <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Periodontal Screening:</label><br>
                    <label for="cancer" style="text-transform: capitalize;font-size:12px">Gingivits</label><br>
                    <label for="heart" style="text-transform: capitalize;font-size:12px">Early Periodontitis</label><br>
                    <label for="hypertension" style="text-transform: capitalize;font-size:12px">Moderate Periodontitis</label><br>
                    <label for="thyroid" style="text-transform: capitalize;font-size:12px">Advance Periodontitis</label><br>
                  </div>
                </div>
                <div class=" mx-auto">
                  <div class="form-group">
                    <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Occlusion:</label><br>
                    <label for="diabetes" style="text-transform: capitalize;font-size:12px">Class(Molar)</label><br>
                    <label for="mental" style="text-transform: capitalize;font-size:12px">Overjet</label><br>
                    <label for="asthma" style="text-transform: capitalize;font-size:12px">Overbite</label><br>                       
                    <label for="convulsion" style="text-transform: capitalize;font-size:12px">Midline Deviation</label><br>   
                    <label for="bleeding" style="text-transform: capitalize;font-size:12px">Crossbite</label><br>
                  </div>
                </div>
            </div>
            <div class="row" >
                <div class=" mx-auto">
                  <div class="form-group">
                    <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">Appliances:</label><br>
                      <label for="vehiceyele1" style="text-transform: capitalize;font-size:12px">Orthodontic</label><br>
                      <label for="skin" style="text-transform: capitalize;font-size:12px">Stayplate</label><br>
                      <label for="vehicle2" style="text-transform: capitalize;font-size:12px">Others</label>
                  </div>
                </div>
                <div class=" mx-auto">
                    <div class="form-group">
                      <label for="cancer" style="text-transform: capitalize;font-size:15px;font-weight:bold">TMD:</label><br>
                      <label for="diabetes" style="text-transform: capitalize;font-size:12px">Clenching</label><br>
                      <label for="mental" style="text-transform: capitalize;font-size:12px">Clicking</label><br>
                      <label for="asthma" style="text-transform: capitalize;font-size:12px">Trismus</label><br>
                      <label for="convulsion" style="text-transform: capitalize;font-size:12px">Muscle Spasm</label>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>

<script>
    $.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
    
//  $("#treatmentRecord").on("shown.bs.modal", function(e){
//   $.ajax({
//     type: 'post',
//     url: '/open-file',
//     data:{ id: $(e.relatedTarget).data("id")},
//     dataType: 'json',
//     success: function(response) {
//      console.log('open')
//     }
//     })
//   })
$(document).ready(function() {
    $('.viewModal').click(function() {
        var patientId = $(this).attr('patientId');
        var toothId = $(this).attr('toothId');
       
        $.ajax({
            url: '/view-modal',
            type: 'POST',
            data: { 
                patientId: patientId,
                toothId: toothId
            },
            success: function(response) {
                console.log(response);
                $('#treatmentRecord').modal('show')
                // Dump the patientId value
                console.log(response.patientId);
                $('.teethId').val(response.toothId);
                $('.patientId').val(response.patientId);
            } 
        });
    });
});


$("#treatmentRecord").on("hide.bs.modal", function(e){
      $("input:checkbox").each(function() {
          $(this).prop("checked", false);  
      });
  })
// $(document).on('click', '.viewModal', function(){
//   var dataId = $(this).attr('id');

//     $.ajax({
//         type: 'post',
//         url: '/view-modal',
//         data: {dataId: dataId},
//         success: function(response) {
//             console.log(response.id, response.id2);
//             $("#treatmentRecord").modal('show');
//             $('.patientId').val(response.id);
//             $('.teethId').val(response.id2);

//             if (response.id) {

//                     var condition = response.condition;
//                     var restoration = response.restoration;
//                     var surgery = response.surgery;
//                     var others = response.others;
//                     var periodontal = response.periodontal;
//                     var occlusion = response.occlusion;
//                     var appliances = response.appliances;
//                     var tmd = response.tmd;

//                     $('.id').val(response.id); 
//                     // $('.fullname').val([response.last_name]+', '+[response.first_name]+' '+[response.middle_name]);
//                     $('.treatment').val(response.treament);
//                     $('.date').val(response.date);             
//                     $('.diagnosis').val(response.diagnosis);
//                     $('.others_app').val(response.others_app);
                    
//                     $("input:checkbox").each(function() {
//                         if (condition.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (restoration.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (surgery.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (others.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (periodontal.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });  

//                     $("input:checkbox").each(function() {
//                         if (occlusion.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (appliances.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });

//                     $("input:checkbox").each(function() {
//                         if (tmd.includes($(this).prop("value"))) {
//                             $(this).prop("checked", true);
//                         }
//                     });  
//                     } else {
//                     // Only student_info has data
//                     console.log(response.id)
//                     var student_info = {
//                         'id': response.id,
//                         // 'last_name':response.last_name,
//                         // 'middle_name' : response.middle_name,
//                         // 'first_name' : response.first_name,
//                         // Add other fields from student_info table as needed
//                     };
//                     $('.id').val(student_info.id); 
//                     // $('.fullname').val([student_info.last_name]+', '+[student_info.first_name]+' '+[student_info.middle_name]);
//                     }
//                     }
//                     })
//         })

</script>
@endsection