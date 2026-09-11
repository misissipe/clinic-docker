<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="editReferral" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color:white;" class='col-12 modal-title'>EDIT INFORMATION</h5> <br>
            </div>
            <div class="modal-body">    
              <form  action="/saveEdit" method="post" id="saveEditRefer">
                @csrf 
                <input type="hidden" class="id" name="id" id="cert_id" value="{{$cipher->encrypt($name->id)}}" placeholder="id" >
                <input type="hidden" class="patientId" name="patientId" id="id" placeholder="id" >
                <input  class="form-control " name="role" type="" value="{{$role}}" id="" hidden> 
              <div class=" form-group col-sm-12">
                <div class="row">            
                  Name:
                  <input type="text" class=" col-sm-8 fullname" name="lastname"  id="fullname"  readonly> 
                </div>
              </div><hr>
              <div style="text-align: right">
                  Date:
                  <input  class="form-control col-sm-3 date cert float-right" name="date" type="date" value="" id="date">
              </div>
              <div class="form-group col-12">
                <div style="font-weight: 500; font-size: 15px;font-style: bold;">REFERRED TO:</div>
                  <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="hospital" name="referTo[]" value="Hospital" onclick="selectCheckbox('hospital')">
                    HOSPITAL </div>
                    <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="rhu" name="referTo[]" value="RHU" onclick="selectCheckbox('rhu')">
                    RHU</div> 
                    <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="visiting_physician" name="referTo[]" value="Visiting Physician" onclick="selectCheckbox('visiting_physician')">
                    VISITING PHYSICIAN</div>
                    <div style="font-weight: 400; font-size: 13px;">
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others" onclick="selectCheckbox('others')">
                    OTHERS (please specify)
                    <input class="others col-sm-2 cert" type="text" id="othersinput" name="others" value="" >
                  </div> 
                </div>
                <div class="form-group">
                    <input type="text" class="form-control id" id="id" name="patientId" hidden >
                </div>
                <div class="col-sm-12">
                    <div style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:</div>
                    <textarea class="form-control col-12 reason @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" required autocomplete="reason" id="reason" rows="5"></textarea>
                </div><br>
                <div class="modal-footer">
                    <button id="updateBtn" type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
          </div> 
        </div> 
      </div> 
    </div> <!-- End Modal -->
            