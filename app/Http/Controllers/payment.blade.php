<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
     select option:hover {
        cursor: pointer;
    }
    .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
  }
  
</style>
<!-- Editing form modal -->
<div id="payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 style="font-weight: bold; color: white; height: 10px;">Payment</h5>
            </div> --}}
            <form action="/payment" method="POST" id="paymentOR">
                @csrf
                <div class="modal-body">
                    <div class="" style="text-align: center"> 
                        <h5>Southern Leyte State University</h5>
                        <h6>DENTAL SERVICES</h6>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" style="display: inline-block;" class="form-control id" id="id" value="">
                        <input type="hidden" name="status" style="display: inline-block;" class="form-control col-5" value="Pending">
                        <div style="text-align: right">
                            <div style="font-weight: 400; font-size: 20px;">
                                <label for="example-month-input" class="col-2 ">date</label>
                                <input class="form-control col-sm-4 float-right date" name="date" type="date" value="" id="viewDate">
                            </div>
                        </div>
                        <br>
                        <div class="">
                            <label for="date" style="display: inline-block;text-transform:capitalize">Name:</label>
                            <input type="text" id="name" style=" display: inline-block;width:70%" class="cert name" name="name" value=""/>
                            <label for="time" style="display: inline-block;text-transform:capitalize">Age:</label>
                            <input type="text" id="time" style="display: inline-block;width:10%" class=" cert age" name="time" value="" />
                        </div>
                        <br>
                        <div class="">
                            <label for="date" style="display: inline-block;text-transform:capitalize">Remarks:</label>
                            <input type="text" name="remarks" style="display: inline-block;" class=" remarks col-5 or" value="">
                            </div>
                        <div class="">
                        <label for="date" style="display: inline-block;text-transform:capitalize">OR Number:</label>
                        <input type="number" name="ORnumber" style="display: inline-block;" class=" or form-control col-5 or" value="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
