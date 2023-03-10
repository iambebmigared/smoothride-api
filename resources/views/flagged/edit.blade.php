@extends('layouts.dash')
@section('css')
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <style>
        .circle_img{
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>

@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="element-wrapper">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
            
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            
                    <h5 class="form-header">Edit Trip</h5> 
                    <form action="{{route('flagged.edit.post', $trip->id)}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <label>Trip Cost</label>
                        <input type="text" name="trip_cost" class="form-control" data-error="" placeholder="Trip Cost" value="{{$trip->tripAmt}}" required><br>
                        <label>Trip Time</label>
                        <input type="text" name="trip_time" class="form-control" placeholder="Trip Time" value="{{$trip->travelTime}}" required><br>
                        <label>Trip Distance</label>
                        <input type="text" name="trip_distance" class="form-control" placeholder="Trip Distance" value="{{$trip->tripDist}}" required><br>
                        <label>Trip Pickup</label>
                        <input type="text" name="pickup" class="form-control" placeholder="PickUp Address" value="{{$trip->pickUpAddress}}" required><br>
                        <label>Trip Destination</label>
                        <input type="text" name="destination" class="form-control" placeholder="Destination" value="{{$trip->destAddress}}" required><br>

                        <center><button class="btn btn-sm btn-primary" name="submit">Update Trip</button></center>
                        </div>
                    </form>
                    <center><a href="{{route('flagged.index')}}" class="text-center">&larr; Go Back</a></center>
                </div>
            </div>
        </div>
    </div>
                             </div>


                    
                             
                            </div></div>
@endsection

@section('script')
 <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
            
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12]
                }
            },
        ]
            } );
        } );
    </script>
@endsection