@extends('layouts.admin_layout')
@section('content')
<div class="container">
            <div class="titlebar">
                        <h4 class="hf mb-3">Edit Doctor</h4>
                        
            
</div>
<div class="row">
            <div class="col-md-8">
               <a href="{{route('admin.doctors')}}" class="btn btn-light btn-sm px-3 mb-2">Back</a>

                        <form action="{{route('edit.edit_doctor')}}" method="post">
                        @csrf
                     @foreach ($data as $row)
                         
                     <input type="hidden" name="id" value="{{$row->id}}">
                   
                        <div class="card shadow">
      <div class="card-body">
    <div class="container">

     
         <div class="row">
            <div class="col-md-6">
                        <h6  class="af">First Name :</h6>  
                        <input type="text" name="Firstname" class="form-control mb-2 @error('Firstname') is-invalid  @enderror" value="{{$row->firstname}}">        
                        @error('Firstname')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <div class="col-md-6">
                        <h6  class="af">Last Name :</h6>  
                        <input type="text" name="Lastname" class="form-control mb-2 @error('Lastname') is-invalid  @enderror" value="{{$row->lastname}}">        
                        @error('Lastname')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>

            <div class="col-md-6">
                        <h6  class="af">Email:</h6>  
                        <input type="text" name="Email" disabled class="form-control mb-2 @error('Email') is-invalid  @enderror" value="{{$row->email}}">        
                        @error('Email')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <div class="col-md-6">
                        <h6  class="af">Contact No :</h6>  
                        <input type="number" onKeyPress="if(this.value.length==11) return false;" name="Contact"  class="form-control mb-2 @error('Contact') is-invalid  @enderror" value="{{$row->contact}}">        
                        @error('Contact')
                           <div class="invalid-feedback">
                                       {{$message}}
                           </div>
                        @enderror
            </div>
            <h6 class="af" style="font-weight: bold">Address</h6>
            <div class="col-md-4">
                        <h6  class="af">Street :</h6>  
                        <input type="text" name="Street" class="form-control @error('Street') is-invalid  @enderror" value="{{$row->street}}" >  
                        
                        @error('Street')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6  class="af">Barangay :</h6>  
                        <input type="text" name="Barangay" class="form-control @error('Barangay') is-invalid  @enderror" value="{{$row->barangay}}">   
                        
                        @error('Barangay')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror
            </div>
            <div class="col-md-4">
                        <h6  class="af">City :</h6>  
                        <input type="text" name="City" class="form-control @error('City') is-invalid  @enderror" value="{{$row->city}}">     
                        @error('City')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror    
            </div>
            <div class="col-md-12 mt-3">
                         
                        <h6  class="af">License No:</h6>  
                        <input type="text" name="License" disabled class="form-control @error('License') is-invalid  @enderror" value="{{$row->license}}">     
                        @error('License')
                        <div class="invalid-feedback">
                                    {{$message}}
                        </div>
                     @enderror    
           
            </div>

{{-- 
            <div class="col-md-12">
                         
                        <h6  class="af">Clinic:</h6>  
                     <select name="Clinic" class="form-select @error('Clinic') is-invalid @enderror" id="clinic">
                        <option value="">Select Clinic</option>
                        @foreach ($clinics as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      
                     </select>
                     @error('Clinic')
                     <div class="invalid-feedback">
                                 {{$message}}
                     </div>
                  @enderror   
            </div>

            
            <div class="col-md-12">
                     
                     <h6 class="af">Select Category:</h6>  
                     <div id="category_select">
                        <select disabled name="Category" class="form-select" >
                                    <option value=""></option>
                                 </select>
                     </div>
               
         
         </div> --}}
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