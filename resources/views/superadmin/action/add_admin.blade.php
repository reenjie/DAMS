@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Add Admin</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('superadmin.admin')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('add.add_admin')}}" method="post">
                        @csrf
                     
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">

     
         <div class="row">
            
            
            <!-- <div class="col-md-6">
               <h6  class="af">Designation:</h6>  
                  
               <select name="Designation" class="form-select" required id="">
                  <option value="">-- Select Designation --</option>
                  <option value="Administrator">Administrator</option>
                  <option value="Doctor">Doctor</option>
                  <option value="Nurse">Nurse</option>
                  <option value="Assistant">Assistant</option>
                  <option value="Secretary">Secretary</option>
               </select>
               @error('Designation')
                  <div class="invalid-feedback">
                              {{$message}}
                  </div>
               @enderror
   </div>
   <div class="col-md-6"></div> -->

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

            <div class="col-md-12">
                        <h6  class="af">Name :</h6>  
                        <input type="text" name="Name" class="form-control mb-2 @error('Name') is-invalid  @enderror" value="{{old('Name')}}">        
                        @error('Name')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <h6 class="af" style="">Address</h6>
            <div class="col-md-12">
                       <textarea name="Address" style="resize: none" class="form-control @error('Address') is-invalid  @enderror" id="" cols="5" rows="5">{{old('Address')}}</textarea>
                       
                        {{-- /designation --}}
                        @error('Address')
                        <div class="invalid-fe edback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>

           
   
            <div class="col-md-12 mt-2">
         <h6  class="af">Password :</h6>  
                        <input type="text" required name="password" id="pass" class="form-control @error('password') is-invalid  @enderror" value="{{old('password')}}">     
                        @error('password')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror

                     <button type="button" id="usedef" class="mt-2 btn btn-light text-primary btn-sm">Use Default Password <i class="fas fa-key"></i></button>
         

         </div>
           
      
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
   $('#usedef').click(function(){
      $('#pass').val('secret');
   })
</script>

@endsection