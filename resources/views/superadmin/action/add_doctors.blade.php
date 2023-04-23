@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Add Doctor</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('superadmin.doctors')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('add.add_doctor')}}" method="post">
                        @csrf
                     
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">

     
         <div class="row">
            <div class="col-md-6">
                        <h6  class="af">First Name :</h6>  
                        <input type="text" name="Firstname" class="form-control mb-2 @error('Firstname') is-invalid  @enderror" value="{{old('Firstname')}}">        
                        @error('Firstname')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <div class="col-md-6">
                        <h6  class="af">Last Name :</h6>  
                        <input type="text" name="Lastname" id="lastname" class="form-control mb-2 @error('Lastname') is-invalid  @enderror" value="{{old('Lastname')}}">        
                        @error('Lastname')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>

            <div class="col-md-6">
                        <h6  class="af">Email:</h6>  
                        <input type="text" name="Email" class="form-control mb-2 @error('Email') is-invalid  @enderror" value="{{old('Email')}}">        
                        @error('Email')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <div class="col-md-6">
                        <h6  class="af">Contact No :</h6>  
                        <input type="number" onKeyPress="if(this.value.length==11) return false;" name="Contact"  class="form-control mb-2 @error('Contact') is-invalid  @enderror" value="{{old('Contact')}}">        
                        @error('Contact')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <h6 class="af" style="font-weight: bold">Address</h6>
            <div class="col-md-4">
                        <h6  class="af">Street :</h6>  
                        <input type="text" name="Street" class="form-control @error('Street') is-invalid  @enderror" value="{{old('Street')}}" >  
                        
                        @error('Street')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6  class="af">Barangay :</h6>  
                        <input type="text" name="Barangay" class="form-control @error('Barangay') is-invalid  @enderror" value="{{old('Barangay')}}">   
                        
                        @error('Barangay')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6  class="af">City :</h6>  
                        <input type="text" name="City" class="form-control @error('City') is-invalid  @enderror" value="{{old('City')}}">     
                        @error('City')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror    
            </div>
            <div class="col-md-12">
                         
                        <h6  class="af">License No:</h6>  
                        <input type="text" name="License" class="form-control @error('License') is-invalid  @enderror" value="{{old('License')}}">     
                        @error('License')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror    
           
            </div>


      

            
            <div class="col-md-12 mt-2">
                     
                   <h6>Select Specialization</h6>
                   @php
                   $sp = DB::select('SELECT * FROM `categories`');
                @endphp
               
              
                   <ul class="list-group">
                     @foreach($sp as $row)
               
                     <li class="list-group-item "><input type="checkbox"  id="check{{$row->id}}" name="specialization[]" value="{{$row->id}}">
                        <label for="check{{$row->id}}">{{$row->name}}</label> <span style="font-size:12px;color:gray;float: right;"><span style="font-size:9px">Created At : </span>{{date('F j, Y',strtotime($row->created_at))}}</span></li>
                     @endforeach
                   
                    
                   </ul>
         
         </div>
         </div>

         <div class="col-md-12 mt-2">
         <h6  class="af">Password :</h6>  
                        <input type="text" name="password" id="pass" class="form-control @error('password') is-invalid  @enderror" value="{{old('password')}}">     
                        @error('password')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
         </div>
      
         <button type="submit" class="btn btn-success mt-3 px-4 ">Submit</button>
    </div>
                        
    </div>
                        </div>
            </form>
            </div>
</div>

</div>
<script>
   $('#lastname').keyup(function(){
      var val = $(this).val();

      $('#pass').val('doc_'+val);
   })
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