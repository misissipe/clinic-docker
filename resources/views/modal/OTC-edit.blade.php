<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="OTCEdit" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>EDIT</h5>
            </div>
            <form action="/new-update-OTC-medicine" method="POST" id="updateOTCModal">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                    <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 20px;">
                            <label for="example-month-input" class="col-2">date</label>
                            <input class="form-control col-sm-3 date float-right @error('date') is-invalid @enderror" name="date" required autocomplete="date" type="date" id="viewDate">
                        </div>
                    </div>
                    <div class="form-outline">
                        <label class="form-label" for="textAreaExample">Remarks:</label>
                        <textarea class="form-control @error('OTCremarks') is-invalid @enderror" name="OTCremarks" required autocomplete="OTCremarks" id="OTCremarks" rows="5"></textarea>
                    </div>
                    <br>
                    <div class="form-outline">
                        <button class="btn btn-success" id="add-input" type="button">Add</button><br>
                        <label class="form-label" style="display: inline-block;" for="textAreaExample">Medicine:</label>
                        <div id="inputs-container">
                            <div class="input-group">
                                <input type="number" class="form-control col-sm-1" style="display: inline-block;" name="OTCmedpcs[]" required autocomplete="OTCmedpcs" aria-describedby="" placeholder="pcs.">
                                <input type="text" class="form-control col-sm-4 " style="display: inline-block;" name="OTCmedDescript[]" required autocomplete="OTCmedDescript" aria-describedby="" placeholder="description">
                                <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submitBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>           
        </div>
    </div>
</div>
