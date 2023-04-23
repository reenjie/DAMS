@extends('layouts.user_layout')
@section('content')
    <div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Send Feedback</h4>         
                    </div>
     
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow">
                            <div class="card-body">
                        <div class="container">
                                    <form action="{{route('add.sendfeedback')}}" method="post">
                                                @csrf
                                  
                         <h6 class="af" style="font-size:14px">Message:</h6>
                      <textarea name="message" class="form-control" style="font-size:13px;resize:none" placeholder="Type your message here.." id="message" cols="30" rows="10"></textarea>
                      <div class="invalid-feedback">
                        <span style="font-size:12px">Please provide your message.</span>
                      </div>
                      <input type="hidden" value="from_user" name="from">
                      <br>
                      <button  type="button" id="sendmessage" style="float: right" class="btn btn-light btn-sm text-success">Send <i class="fas fa-paper-plane"></i></button>

 
          
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
            
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <h6 class="hf">Select Receiver <br>
                                    <span class="text-secondary af" style="font-size:12px;" >Clinics you have requested with appointments</span>
                        </h6>
                      
            <ul class="list-group list-group-flush">
                        @foreach ($clinics as $item)
                        <li class="list-group-item"><span class="text-primary" style="font-weight: bold">{{$item->name}}</span>  <span style="float:right" style="font-size:13px"><button type="submit" class="btn btn-light text-primary btn0-sm" name="selected" value="{{$item->id}}">Select</button></span></li>
                        @endforeach
         
            </ul>
                </div>
                <div class="modal-footer">
                  
                </div>
              </div>
            </div>
          </div>

</form>
                        </div>
                         </div>
                            </div>

                                    
                        </div>

                        <div class="col-md-12 mt-2">
                           <h6 class="af">My Feedbacks</h6>

                           @if(count($allclinic)>=1)
                           @foreach ($allclinic as $item)
                             <div class="card shadow mb-2">
                                
                                 <div class="card-body">
             
                                     <div class="row">
                                         <div class="col-md-4">
                                        <h6 class="af text-primary" style="font-weight: bold;font-size:17px;text-align:center">
                                                
                                                 
                                                <h4 class="text-primary" style="font-weight: bold">    {{$item->name}}</h4>
                                          
                                                <span style="font-size:14px;color:grey">Address:</span>
                                                <br>

                                                {{$item->street.' '.$item->barangay.' '.$item->city}}
                                                
                                                 </h6>
                                                
                                           
             
                                         </div>
                                         <div class="col-md-8">
                                             <div class="container" style="height: 400px;overflow-Y:scroll">
                                                 <div class="row">
         
                                              
                                                 @foreach ($data as $row)
                                                     @if($row->clinic == $item->id)
                                                         @if($row->from_clinic >=1)
                                                      
                                                         <div class="col-md-6">
                                                             <div class="card mt-2" style="background-color: rgb(225, 242, 243)">
                                                             
                                                                 <span style="font-size: 12px;color:grey;padding:2px">{{date('h:m a | M j,Y',strtotime($row->created_at))}}</span>
                                                                 <span style="font-size: 12px;font-weight:bold;padding:5px" class="text-primary">{{$item->name}}</span>
                                                                 <div class="card-body">
                                                                  
                                                                     <span class="text-secondary">
                                                                         {{$row->message}}
                                                                     </span>
                                                                 </div>
             
                                                             </div>
             
                                                         </div>
                                                         <div class="col-md-6"></div>
                                                       
                                                         @else 
                                                         <div class="col-md-6"></div>
                                                         <div class="col-md-6">
                                                             <div class="card mt-2 ">
                                                            
                                                                 <span style="font-size: 12px;color:grey;padding:2px">{{date('h:m a | M j,Y',strtotime($row->created_at))}}</span>
                                                                 <span style="font-size: 12px;font-weight:bold;padding:5px" class="text-primary">You</span>
                                                                 <div class="card-body">
                                                                  
                                                                     <span class="text-secondary">
                                                                         {{$row->message}}
                                                                     </span>
                                                                 </div>
             
                                                             </div>
             
                                                         </div>
                                                       
         
                                                         @endif
                                                    
                                                     @endif
                                                     
                                                 @endforeach
                                             </div>
         
                                                 <h6 class="af mt-2" style="font-size:14px">
                                                 
                                               
                                                 </h6>
                                                 <br>
                                                
         
                                               {{-- <button  style="position: absolute;right:20px;bottom:10px" 
                                                 data-id ="{{$item->id}}" class="btndelete btn btn-light text-secondary btn-sm" style="font-size:13px"><i  class="fas fa-trash-can"></i></button> --}}
                                             </div>
                                             <form action="{{route('add.sendfeedback')}}" id="formsub" method="post">
                                                 @csrf
                                           <div class="row p-3">
                                             <div class="col-md-8">
                                                 <textarea class="form-control" style="font-size:14px" placeholder="Type your Message here.." name="message" id=""  row="3"
                                                 required
                                                 ></textarea>    
                                             </div>
                                             <div class="col-md-2">
                                                 <button type="submit" 
                                                 id="btnsendmessage"
                                                 class="mt-2" style="outline: none;border:none;font-weight:normal;color:rgb(112, 112, 211)">Send <i class="fas fa-paper-plane"></i></button>
                                             </div>
                                       
                                         </div> 
                                         <input type="hidden" value="from_user" name="from">
                                         <input type="hidden" value="{{$item->id}}" name="selected">
                                     </form>
             
                                         </div>
                                     </div>
                                    
                                 </div>
                                 
                             </div> 
         
         
                             @endforeach 
                             @else 
                             <h6 style="text-align: center" class="af">
                                 <img src="https://luansteflideas.files.wordpress.com/2011/12/feedback.jpg" class="img-fluid" alt="">
                                 <br>
                                 No Feedbacks yet..
                             </h6>
                             @endif
         
                        </div>
                    </div>
    </div>

    @if(Session::get('Success'))
    <script>
        swal("Deleted Successfully!", "", "info");
     </script>
      
      @elseif(Session::get('Sent'))
      <script>
            swal("Thanks for Sending Feedback!", "Your Message has been Sent Successfully", "success");
      </script>
    @endif

    <script>
        $('#formsub').on('submit',function(){
          
            $('#btnsendmessage').html('<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>');
        })
            $('#sendmessage').click(function(){
                  var val = $('#message').val();
                if(val == ''){
                        $('#message').addClass('is-invalid');
                }else {
                   $('#exampleModal').modal('show');     
                }
            })
            $('#message').keyup(function(){
                        $('#message').removeClass('is-invalid');
            })


            $('.btndelete').click(function(){
        var id =$(this).data('id');
       
        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $(this).html('<span class="text-secondary" style="font-size:11px">Deleting..</span>');
    window.location.href='{{route("delete.delete_feedback")}}'+'?id='+id;
  } else {
  
  }
});
    })
           
    </script>

@endsection