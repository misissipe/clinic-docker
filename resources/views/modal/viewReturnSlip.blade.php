<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div id="viewReturnSlip" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/delete" method="POST" id="deleteModal">
                @csrf
                <div class="modal-header">
                    <h6 style="font-weight: bold; color:white;" class="modal-title">VIEW UPLOADED FILE</h6>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <img id="file-preview" src="" alt="img" style="width: 70%; height: 70%; max-width: 100%; max-height: 100%;" allowfullscreen>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

