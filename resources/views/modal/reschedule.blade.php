<style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
     select option:hover {
        cursor: pointer;
    }
</style>
<div id="reschedule" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-weight: bold; color: white; height: 10px;text-align:center">RESCHEDULE</h5>
            </div>
            <form action="/reschedule" method="POST" id="rescheduleModal">
                @csrf
                <div class="modal-body">
                    <div>
                        <input type="hidden" name="id" style="display: inline-block;" class="form-control" id="id" value="{{$data->id ?? ""}}">
                        <input type="hidden" name="status" style="display: inline-block;" class="form-control col-5" value="Pending">
                        <div style="font-size:18px; font-weight:600">PREVIOUS SCHEDULE</div>
                        <div style="font-size:14px; font-weight:400">DATE: {{ date('m-d-Y', strtotime($data->date ?? "")) }}</div>
                        <div style="font-size:14px; font-weight:400">TIME: {{date('h:i A', strtotime($data->time ?? ""))}}</div>
                        {{-- <div style="font-size:14px; font-weight:400">STATUS: {{$data->status ?? ""}}</div> --}}
                        <hr>
                        <div class="col-md-12">
                            <label for="date" style="display: inline-block;">Date:</label>
                            <input type="date" id="date" style="display: inline-block;" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" />
                            <br>
                            <label for="time" style="display: inline-block;">Time:</label>
                            <input type="time" id="time" style="display: inline-block;" class="form-control @error('time') is-invalid @enderror" name="time" value="{{ old('time') }}" required autocomplete="time" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
