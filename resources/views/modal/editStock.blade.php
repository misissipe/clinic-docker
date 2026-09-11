<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="updateStock" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'></h5>
            </div>
            <form action="/updateStock" method="POST" id="updateStockForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                    <label for="lotno">Batch/Lot No.:<span class="text-danger">*</span></label>
                    <input type="text" id="lotno" class="form-control lotno @error('batchNo') is-invalid @enderror" name="batchNo" value="{{ old('lotno') }}" required autocomplete="batchNo"/>

                    <label for="itemname1">Medicine Name:<span class="text-danger">*</span></label>
                    <input type="text" name="itemname"  id="itemname1" class="form-control @error('itemname') is-invalid @enderror" name="itemname" value="{{ old('itemname') }}" required autocomplete="itemname" placeholder="" readonly/>
                    
                    <label for="quantity1">Quantity:<span class="text-danger">*</span></label>
                    <input type="text" name="quantity"  id="quantity1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" placeholder="" />
                   
                    <label for="measure1">Unit of Measure:<span class="text-danger">*</span></label>
                    <select name="measure" id="measure1" class="form-control @error('measure') is-invalid @enderror" required>
                        <option value="" disabled selected>Select Unit of Measure</option>
                    </select>      

                    <label for="expirationdate1">Expiration Date:<span class="text-danger">*</span></label>
                    <input type="date" name="expirationdate" id="expirationdate1" class="form-control @error('expirationdate') is-invalid @enderror" name="expirationdate" value="{{ old('expirationdate') }}" required autocomplete="expirationdate" placeholder="" />
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>           
        </div>
    </div>
</div>
