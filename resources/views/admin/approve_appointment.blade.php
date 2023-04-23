



  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h6 style="font-weight: normal;font-size:12px" class="af mb-2">-- Diagnostics --</h6>
        <textarea name="diagnostics" style="font-size:13px" placeholder='Type Diagnostics here..' class="form-control" id="{{$row->id}}diagnostics" cols="30" rows="5"></textarea>
        <br>

        <h6 style="font-weight: normal;font-size:12px" class="af mb-2">Medical Certificate</h6>
        @php
        $attachments = DB::select('select * from attachments where appt = '.$row->id.' ');
    @endphp
 @if(count($attachments) == 0)

    
<button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#fileattach{{$row->id}}" style="font-size:14px">
Attach file
</button>

<!-- Modal -->
<div class="modal fade" id="fileattach{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog  modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title fs-5" id="exampleModalLabel">Choose File</h6>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{route('admin.attachedfile')}}" method="post" enctype="multipart/form-data">
@csrf
<div class="modal-body">

<input type="file" name="imgfile[]" multiple required accept="image/*" data-id="{{$row->id}}" class="onUpload form-control" style="font-size:14px"/>
<input type="hidden" value="{{$row->id}}" name="apptid">
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary btn-sm">Upload</button>
</div>
</form>
</div>
</div>
</div>

@else
<div class="p-2">

@foreach ($attachments as $fileitems)
<a href="{{asset('attachments/').'/'.$fileitems->file}}" target="_blank">
<i class="fas fa-image"></i> {{$fileitems->file}}
</a>
<br>
@endforeach


<button class="clearattach" data-id="{{$row->id}}" style="float: right;font-size:14px;color:rgb(204, 28, 28);outline:none;border:none"> remove</button>
</div>



@endif
        
      </div>
      <div class="col-md-6 mt-2">
        <h6 style="font-weight: normal;font-size:12px" class="af">Add Treatment </h6>
        <textarea name=""  id="{{$row->id}}treatment" style="resize: none;font-size:13px" class="rem form-control" id="" cols="5" rows="5" placeholder="Type Treatment here."></textarea>
        
      </div>

      <div class="col-md-6 mt-2">
        <h6 style="font-weight: normal;font-size:12px" class="af">Add Remarks</h6>
        <textarea name="" style="font-size:13px" id="{{$row->id}}remarks" style="resize: none" class="rem form-control" id="" cols="5" rows="5" placeholder="Type Remarks here."></textarea>
        <div class="invalid-feedback">
            <span style="font-size:12px">Please Provide Remarks *</span>
        </div>
      </div>

      <div class="col-md-12">
        <button data-id="{{$row->id}}" class="btndone mt-2 btn btn-success btn-sm af">Mark as Done</button>

        <button data-id="{{$row->id}}" data-pid="{{$p_id}}" style=" font-weight: bold" class="btnrefer mt-2 btn btn-light text-danger btn-sm af">REFER</button>
      </div>
    </div>
  </div>

  <script>
     $('.btndone').click(function(){
        var id = $(this).data('id');
        var val = $('#'+id+'remarks').val();
        var treat = $('#'+id+'treatment').val();
        var diagnostics = $('#'+id+'diagnostics').val();
       if(val == '' && treat == ''){
        $('#'+id+'remarks').addClass('is-invalid');
        $('#'+id+'treatment').addClass('is-invalid');
       }else if(treat == '') {
        $('#'+id+'treatment').addClass('is-invalid');
       }else if(val == '') {
        $('#'+id+'remarks').addClass('is-invalid');
       }else{
        window.location.href='{{route("home.complete_booking")}}'+'?id='+id+'&remarks='+val+'&treatment='+treat+'&diagnostics='+diagnostics;
       }
    })

    $('.btnrefer').click(function(){
        var id = $(this).data('id');
        var pid = $(this).data('pid');
        var val = $('#'+id+'remarks').val();
       if(val == ''){
        $('#'+id+'remarks').addClass('is-invalid');
       }else {
        window.location.href='{{route("admin.refer")}}'+'?id='+id+'&remarks='+val+'&patientId='+pid;
       }
    })

  </script>
