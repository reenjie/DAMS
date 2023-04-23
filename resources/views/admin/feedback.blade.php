@extends('layouts.admin_layout')

@section('content')
   <div class="container">
    <div class="titlebar">
        <h4 class="hf mb-3">Feedbacks</h4>
        
    </div>
   
        <div class="container">
            <div class="row">
            
                <div class="col-md-12">
                    @if(Session::get('Success'))
                    <div class="row">
                     <div class="col-md-8"></div>
                     <div class="col-md-6">
                         <div class="alert alert-success alert-dismissible fade af show" role="alert">
                            {{Session::get('Success')}}
                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                           </div>
                     </div>
                    </div>
                    
                 @endif
                @if(count($alluser)>=1)
                  @foreach ($alluser as $item)
                    <div class="card shadow mb-2">
                       
                        <div class="card-body">
    
                            <div class="row">
                                <div class="col-md-4">
                                 
                                        
                                        <h6 class="af text-primary" style="font-weight: bold;font-size:17px;text-align:center">
                                            <img src="https://th.bing.com/th/id/OIP.Bt2tDCEAP7IRxzzCaVJEfwHaHa?pid=ImgDet&rs=1" alt="" class="rounded-circle" style="width: 120px">
                                            <br>
                                           {{$item->name}}
                                        <br>
                                        <span class="text-secondary" style="font-size:13px">{{$item->email}}</span>
                                        <br>
                                        <span class="text-secondary" style="font-size:13px">{{$item->contactno}}</span>
                                        </h6>
                                       
                                  
    
                                </div>
                                <div class="col-md-8">
                                    <div class="container" style="height: 400px;overflow-Y:scroll">
                                        <div class="row">

                                     
                                        @foreach ($data as $row)
                                            @if($row->user_id == $item->id)
                                                @if($row->from_user)
                                             
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
                                       

                                      <button  style="position: absolute;right:20px;bottom:10px" 
                                        data-id ="{{$item->id}}" class="btndelete btn btn-light text-secondary btn-sm" style="font-size:13px"><i  class="fas fa-trash-can"></i></button>
                                    </div>
                                    <form action="{{route('add.sendfeedback')}}" method="post">
                                        @csrf
                                  <div class="row p-3">
                                    <div class="col-md-8">
                                        <textarea class="form-control" style="font-size:14px" placeholder="Type your Message here.." name="message" id=""  row="3"
                                        required
                                        ></textarea>    
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="mt-2" style="outline: none;border:none;font-weight:normal;color:rgb(112, 112, 211)">Send <i class="fas fa-paper-plane"></i></button>
                                    </div>
                              
                                </div> 
                                <input type="hidden" value="from_clinic" name="from">
                                <input type="hidden" value="{{$item->id}}" name="userid">
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
   
   </div>

   <script>
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