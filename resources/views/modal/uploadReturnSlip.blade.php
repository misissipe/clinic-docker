<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="uploadReturnSlip" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color:white;" class='modal-title'>UPLOAD RETURN SLIP</h5> <br>
            </div>

            <form id="myForm" action="{{route('upload')}}" method="POST" role="form"  enctype="multipart/form-data">
                @csrf 
            <div class="modal-body">  
                    <div class=" form-group col-sm-12">
                        <div class="form-group">
                            <input type="text" class="form-control id" id="id" name="id" hidden >
                        </div>
                    <div class="row">            
                        Name:
                        <input type="text" class=" col-sm-8 fullname" name="lastname"  id="fullname"  readonly> 
                      </div>
                    </div><hr>
                    <div class=" form-group col-sm-12">
                        <div class="row">            
                            <h6 class="col-3">Referred to:</h6>
                            <input type="text" class="form-control col-sm-8 referTo" name="lastname"  id="fullname"  readonly> 
                        </div>
                    </div>
                    <div class=" form-group col-sm-12">
                        <div class="row">            
                            <h6 class="col-3">Reason for Referral:</h6>
                            <input type="text" class="form-control col-sm-8 reason" name="lastname"  id="fullname"  readonly> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">Select a file to upload</label>
                        <div class="col-md-6">
                            <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="submit-button" type="submit" class="btn btn-primary file">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div> 
        </div> 
    </div> 
</div>
            