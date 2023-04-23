@extends('layouts.admin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Add Doctor</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('admin.doctors')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

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
                        <input type="text" name="Lastname" class="form-control mb-2 @error('Lastname') is-invalid  @enderror" value="{{old('Lastname')}}">        
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



                        <input type="hidden" name="Clinic" value="{{Auth::user()->clinic}}" id="">

            
            <div class="col-md-12">
                     
                     <h6 class="af">Select Category:</h6>  
                     <div id="category_select">
                        <select  name="Category" class="form-select" >
                        @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                         </select>
                     </div>
               
         
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