<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="addProduct" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>Add Product</h5>
            </div>
            <form action="/addProduct" method="POST" id="addProductModal">
                @csrf
                <div class="modal-body">       
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Generic Name:</label>
                        <span class="text-warning">*</span>
                        <input type="text" class="form-control" id="genericname" name="genericname" autocomplete="off" required>
                        <label for="recipient-name" class="col-form-label">Brand Name:</label>
                        <span class="text-warning">*</span>
                        <input type="text" class="form-control" id="brandname" name="brandname" autocomplete="off" required>
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
