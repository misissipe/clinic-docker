<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="editBorrowModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>EDIT BORROWED ITEM</h5>
            </div>
            <form action="/updateModal" method="POST" id="updateBorrowModal">
                @csrf
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" >Borrowed:</label><span class="text-warning">*</span><br>
                        <label for="recipient-name" class="col-form-label" >Date:</label><span class="text-warning">*</span>
                        <input type="date" class="form-control dateB" id="dateB" name="dateB" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Time:</label><span class="text-warning">*</span>
                        <input type="time" class="form-control timeB" id="timeB" name="timeB" autocomplete="off"><hr>
                        <div class="form-outline" id="medicineOTC">
                            <button class="btn btn-success" id="addNewinput1" type="button">Add</button><br>
                            <label class="form-label" style="display: inline-block;" for="textAreaExample">ITEM/S BORROWED::<span class="text-danger">*</span></label>
                            <div id="inputs-container1">
                                <div class="input-group1">
                                <input type="text" class="form-control col-sm-12 item" style="display: inline-block;" name="item[]" aria-describedby="" placeholder="description" autocomplete="off">
                            
                                {{-- <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button> --}}
                                <br><br>
                                </div>
                            </div>  
                        </div>
                        <label for="recipient-name" class="col-form-label" >Returned:</label><span class="text-warning">*</span><br>
                        <label for="recipient-name" class="col-form-label" >Date:</label><span class="text-warning">*</span>
                        <input type="date" class="form-control dateR" id="dateR" name="dateR" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Time:</label><span class="text-warning">*</span>
                        <input type="time" class="form-control timeR" id="timeR" name="timeR" autocomplete="off">
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
