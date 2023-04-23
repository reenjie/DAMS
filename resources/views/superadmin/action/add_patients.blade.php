@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Add Patient</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('superadmin.patients')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('add.add_patient')}}" method="post">
                        @csrf
                     
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">

     
         <div class="row">
            
         

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
                       
                        
                        @error('Address')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>


           
         

         </div>
      
         <button type="submit" class="btn btn-primary mt-3 px-4 ">Submit</button>
    </div>
                        
    </div>
                        </div>
            </form>
            </div>
</div>

</div>

@endsection