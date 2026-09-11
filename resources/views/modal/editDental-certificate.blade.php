<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<!-- Editing form modal -->
<!-- Your modal structure -->
<div id="viewDentalcert" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white;" class='col-12 modal-title move'>EDIT</h5>
            </div>
            <form action="/updateDentalCert" method="POST" id="updateDentalCert">
                @csrf
                <div class="modal-body">       
                    <input type="hidden" class="id" name="id" id="id" placeholder="id" value="">
                    <input type="hidden" class="role" name="role" id="role" placeholder="role" value="">
                    <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 20px;">
                            <label for="example-month-input" class="col-2">date</label>
                            <input class="form-control col-sm-4 date float-right @error('date') is-invalid @enderror" name="date" required autocomplete="date" type="date" id="viewDate">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="date" style="display: inline-block;">Treated by:</label>
                        <input type="text" id="treatedby" style="display: inline-block;" class="form-control treatedby @error('treatedby') is-invalid @enderror" name="treated_by" value="{{ old('treatedby') }}" required autocomplete="text" />
                        <br>
                        <label for="text" style="display: inline-block;">No. of day/s:</label>
                        <input type="text" id="no_days" style="display: inline-block;" class="form-control no_days @error('no_days') is-invalid @enderror" name="no_days" value="{{ old('no_days') }}" required autocomplete="text" />
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
