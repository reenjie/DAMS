@extends('layouts.superadmin_layout')
@section('content')
<script>
    window.location.href='{{route("superadmin.specialization")}}';
</script>
    <div class="container">

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session()->get('success')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    @endif

        <div class="titlebar">
            <h4 class="hf mb-3">Dashboard</h4>
            

        </div>

  
        <div class="row">
    
        </div>



    </div>
  
     

    <script>
        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "Clinics and Appointments"
            },
            axisY: {
                title: "Appointment Bookings"
            },
            data: [{        
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "grey",
                legendText: "Clinics",
                dataPoints: [      
                 
                    @foreach ($Clinic as $row)
                   
         

                 @php
            $count = DB::select('select * from appointments where clinic ='.$row->id.' ');
                 @endphp
        
        { y: {{count($count)}}, label: " {{$row->name}}" },
                @endforeach

                ]
            }]
        });
        chart.render();
        
        }
        </script>
@endsection
