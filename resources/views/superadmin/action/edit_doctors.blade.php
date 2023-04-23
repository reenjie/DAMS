@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Edit Doctor</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('superadmin.doctors')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('edit.edit_doctor')}}" method="post">
                        @csrf
                     @foreach ($data as $row)
                         
                     <input type="hidden" name="id" value="{{$row->id}}">
                   
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">

     
         <div class="row">
         <div class="col-md-12">
                        <h6  class="af">Name :</h6>  
                        <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid  @enderror" value="{{$row->name}}">        
                        @error('name')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
     

            <div class="col-md-6">
                        <h6  class="af">Email:</h6>  
                        <input type="text" name="Email" class="form-control mb-2 @error('Email') is-invalid  @enderror" value="{{$row->email}}">        
                        @error('Email')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <div class="col-md-6">
                        <h6  class="af">Contact No :</h6>  
                        <input type="number" onKeyPress="if(this.value.length==11) return false;" name="Contact"  class="form-control mb-2 @error('Contact') is-invalid  @enderror" value="{{$row->contactno}}">        
                        @error('Contact')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <h6 class="af" style="font-weight: bold">Address</h6>

               <textarea name="address" class="form-control mt-2 mb-2" id="" cols="30" rows="10">{{$row->address}}</textarea>
        
        
            <div class="col-md-12">
                         
                        <h6  class="af">License No:</h6>  
                        <input type="text" name="License" class="form-control @error('License') is-invalid  @enderror" value="{{$row->license}}">     
                        @error('License')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror    
           
            </div>


      

            
            <div class="col-md-12">
            @php
                              $sp = DB::select('SELECT * FROM `categories`');
          @endphp

            
                     
           
                     <div>
                        <select  name="specialization" class="form-select mt-3" value="{{$row->name}}" >
                        @foreach($sp as $ss)
                        @if($ss->id == $row->specialization )
                        <option style="text-align:center" value="{{$ss->id}}">{{$ss->name}}</option>
                        @endif
                        
                                 @endforeach
                           
                                 @foreach($sp as $row)
                                 <option value="{{$row->id}}">{{$row->name}}</option>
                                 @endforeach
                                  
                                 </select>
                     </div>
               
         
         </div>
         </div>
      
         <button type="submit" class="btn btn-primary mt-3 px-4 ">UPDATE</button>
    </div>
                        
    </div>
                        </div>
                        @endforeach
            </form>
            </div>
</div>

</div>
<script>
$('#clinic').change(function(){
var id = $(this).val();
$.ajax({
  url:'{{route("superadmin.getcategory")}}',
  method:'get',
  data : {getcategory:id},
  success: function(data){
        var html =  $('#category_select').html(data);

  }
})

})
</script>
@endsection