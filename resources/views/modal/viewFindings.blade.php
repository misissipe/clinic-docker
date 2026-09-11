<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
  <div class="modal fade bd-example-modal-lg exampleModal"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 style="font-weight: bold;;color:white;" class='col-12 modal-title text-center'>PATIENT RECORD </h5>
        </div>
        <form action="/updatefindings" method="POST" id="updateModal"> 
        @csrf
          <div class="modal-body">
            <div class="row " >
              <div class="col-sm-6">
                <div class="form-group">
                  <div class="form-group ">
                    <label for="day">Student No<span class="text-danger">*</span></label><br>
                    <input class="form-control col-sm-6 StudentNo" type="text" id="StudentNo" name="StudentNo">
                  </div>
                </div>
              </div>
              <div class="col-sm-6" >
                <div class="form-group">
                  <div class="form-group  ">
                    <label for="day">Date</label><br>
                    <input class="form-control col-sm-6 date" type="date" id="date" name="date">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-outline ">
              <label class="form-label" for="textAreaExample">Chief Complain/Findings:</label>
              <textarea class="form-control findings @error('findings') is-invalid @enderror" name="findings" value="{{ old('findings') }}" required autocomplete="findings" id="findings" rows="5"></textarea>
            </div>
            <div class="form-outline">
              <label class="form-label" for="textAreaExample">Physiological Parameters:</label>
              <textarea class="form-control parameters @error('parameters') is-invalid @enderror" name="parameters" value="{{ old('parameters') }}" required autocomplete="parameters" id="parameters" rows="5"></textarea>
            </div>
            <div class="form-outline">
              <label class="form-label" for="textAreaExample">Treatment/Recommendations:</label>
              <textarea class="form-control recommendation @error('recommendation') is-invalid @enderror" name="recommendation" value="{{ old('recommendation') }}" required autocomplete="recommendation" id="recommendation" rows="5"></textarea>
            </div><br>
            <div class="modal-footer">
              <button id="submitBtn" type="submit" class="btn btn-success">Update</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  
   