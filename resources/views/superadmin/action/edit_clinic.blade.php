@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Edit CLinic</h4>
                        
            
</div>
<div class="row">
            
            <div class="col-md-8">
                        <a href="{{route('superadmin.clinics')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('edit.edit_clinic')}}" method="post">
                        @csrf
                     @foreach ($data as $row)
                         
                        <input type="hidden" name="id" value="{{$row->id}}">
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">
         <h6>Name :</h6>  
         <input type="text" name="name" class="form-control mb-2 @error('name') is-invalid  @enderror" value="{{$row->name}}">        
         @error('name')
            <div class="invalid-feedback">
                        {{$message}}
            </div>
         @enderror
         <div class="row">
            <div class="col-md-4">
                        <h6>Street :</h6>  
                        <input type="text" name="street" class="form-control @error('street') is-invalid  @enderror" value="{{$row->street}}" >  
                        
                        @error('street')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6>Barangay :</h6>  
                        <input type="text" name="barangay" class="form-control @error('barangay') is-invalid  @enderror" value="{{$row->barangay}}">   
                        
                        @error('barangay')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6>City :</h6>  
                        <input type="text" name="city" class="form-control @error('city') is-invalid  @enderror" value="{{$row->city}}">     
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
                        @endforeach
            </form>
            </div>
</div>

</div>
@endsection