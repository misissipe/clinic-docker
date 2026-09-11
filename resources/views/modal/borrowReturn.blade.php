<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="returnedBorrowModal" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>RETURNED</h5>
            </div>
            <form action="/returnedBorrow" method="POST" id="addDoctorsModal">
                @csrf
                <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label" >Returned Date:</label><span class="text-warning">*</span>
                        <input type="date" class="form-control" id="returned_date" name="returned_date" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Returned Time:</label><span class="text-warning">*</span>
                        <input type="time" class="form-control" id="returned_time" name="returned_time" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
