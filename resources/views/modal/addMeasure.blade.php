<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="addMeasure" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>Add Measure</h5>
            </div>
            <form action="/addMeasurement" method="POST" id="addMeasureModal">
                @csrf
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Unit of Measure:</label>
                        <span class="text-warning">*</span>
                        <input type="text" class="form-control" id="measurename" name="measurename" autocomplete="off" required>
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
