@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Add CLinic</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('superadmin.clinics')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('add.add_clinic')}}" method="post">
                        @csrf
                     
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">
         <h6>Name :</h6>  
         <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid  @enderror" value="{{old('name')}}">        
         @error('name')
            <div class="invalid-feedback">
                        {{$message}}
            </div>
         @enderror
         <div class="row">
            <div class="col-md-4">
                        <h6>Street :</h6>  
                        <input type="text" name="street" class="form-control @error('street') is-invalid  @enderror" value="{{old('street')}}" >  
                        
                        @error('street')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6>Barangay :</h6>  
                        <input type="text" name="barangay" class="form-control @error('barangay') is-invalid  @enderror" value="{{old('barangay')}}">   
                        
                        @error('barangay')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6>City :</h6>  
                        <input type="text" name="city" class="form-control @error('city') is-invalid  @enderror" value="{{old('city')}}">     
                        @error('city')
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