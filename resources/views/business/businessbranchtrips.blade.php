@extends('layouts.business')
@php
    $months=array_reduce(range(1,12),function($rslt,$m){ $rslt[$m] = date('F',mktime(0,0,0,$m,10)); return $rslt; });
    $years = array_combine(range(date("Y"), 2000), range(date("Y"), 2000));
@endphp
@section('title')
All Trips
@endsection
@section('css')
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="row">
                @if (Auth::user()->largeData == 1)
                    <div class="col-md-4 mb-3">
                        <form action="{{route('filtered.excel')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <select name="year" id="" class="form-control">
                                    @foreach($years as $year)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <select name="month" id="" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach($months as $month)
                                        <option value="{{$month}}">{{$month}}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger">{{$errors->first('month')}}</div>
                            </div>
                    </div>
                    <div class="col-md-4">
                            <button class="btn btn-primary py-2">Download</button>
                        </form>
                    </div>
                @else
                    <div class="col-md-4">
                        <form action="{{route('business.searchbranchbusinesstrip')}}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                        <div class="form-group">
                        <span>From:</span>   <input type="date" name="first" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                    <span>To:</span>  <input type="date" name="second" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" align="center">
                            <button type="submit" name="filter" id="filter" class="btn btn-info">Filter</button>
                        </form>
                        <a href="{{url()->previous()}}" class="btn btn-default">Reset</a>   
                        </div>
                    </div>
                @endif
                
        
</div>

 <div class="element-wrapper">
                                    <div class="element-box">
                                        <div style="overflow-x: scroll; width: 103%" class="table-responsive">
                                            <table id ="xexample"   class="table table-darkborder table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Staff Name</th>
                                                        
                                                        <th class="text-center">Pickup address</th>
                                                        <th class="text-center">Drop address</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Distance</th>
                                                         <th class="text-center">Time</th>
                                                        <th class="text-center">Start Time</th>
                                                        <th class="text-center">End Time</th>
                                                        <th class="text-center">Wait Start Time</th>
                                                        <th class="text-center">Wait End Time</th>
                                                        <th class="text-center">Wait Time</th>
                                                        <th class="text-center">Cost of Waiting</th>
                                                        <th class="text-center">Driver</th>
                                                         <th class="text-center">Branch</th>
                                                    </tr>
                                                </thead>  
                                                <tbody>
                             
                                    @foreach($alltrips as $trip)
                                                    <tr>
                                                        <td>
                                                         
                                                        
                                                        <td>
                                                            <div class="user-with-avatar"><span class="d-none d-xl-inline-block larger darker">{{$trip->user['name']}}</span></div>
                                                        </td>
                                                       
                                                        <td class="text-center"><span class="larger darker">{{$trip->pickUpAddress}}</span></td>
                                                        <td class="text-center"><span class="larger darker">{{$trip->destAddress}}</span></td>
                                                        <td class="text-center"><span class="larger darker">{{ number_format($trip->tripAmt,2) }}</span></td>
                                                        <td class="text-center"><span class="larger darker">{{$trip->tripDist/1000}}km</span></td>
                                                        <td class="text-center"><span class="larger darker">{{ gmdate("H:i:s",$trip->travelTime)}}</span></td>
                                                        <td class="text-center"><span class="larger darker">{{ \Carbon\Carbon::parse($trip->tripEndTime)->subSeconds($trip->travelTime) }}
                                                         {{ \Carbon\Carbon::parse($trip->trip_start_time) }}
                                                         </span></td>
                                                        <td class="text-center"><span class="larger darker"> {{\Carbon\Carbon::parse($trip->tripEndTime)}}</span></td>
                                                         <td class="text-center"><span class="larger darker">{{ $trip->wait_time_start }}</span></td>
                                                          <td class="text-center"><span class="larger darker">{{ $trip->wait_time_end}}</span></td>
                                                         <td class="text-center"><span class="larger darker">{{gmdate("H:i:s",$trip->wait_time)}}</span></td>
                                                          <td class="text-center"><span class="larger darker">{{ $trip->cost_wait }}</span></td>
                                                           <td class="text-center larger darker">{{$trip->driver['name']}}</td>
                                                         <td class="text-center larger darker">{{$trip->branch['name']}}</td>
                                                </tr> 
                                    @endforeach   

                                    <!--
                                     @foreach($alltrips as $trip)
                                                    <tr>
                                                        <td>
                                                            <div class="user-with-avatar"><span class="d-none d-xl-inline-block larger darker">{{$trip->user['name']}}</span></div>
                                                        </td>
                                                       
                                                        <td class="text-center"><span class="larger darker">{{$trip->pickUpAddress}}</span></td>
                                                        <td class="text-center"><span class="larger darker">{{$trip->destAddress}}</span></td>
                                                        <td class="text-center"><span class="larger darker">&#8358; {{ number_format($trip->tripAmt,2) }}</span></td>
                                                        <td class="text-center"><span class="larger darker"> {{$trip->tripDist/1000}}km</span></td>
                                                        <td class="text-center"><span class="larger darker"> {{ gmdate("H:i:s",$trip->travelTime)}}</span></td>
                                                        <td class="text-center"><span class="larger darker">  {{ \Carbon\Carbon::parse($trip->tripEndTime)->subSeconds($trip->travelTime) }}
                                                             {{ \Carbon\Carbon::parse($trip->trip_start_time) }}
                                                         </span></td>
                                                        <td class="text-center"><span class="larger darker"> {{\Carbon\Carbon::parse($trip->tripEndTime)}}</span></td>
                                                         <td class="text-center"><span class="larger darker"> {{ $trip->wait_time_start }}</span></td>
                                                          <td class="text-center"><span class="larger darker"> {{ $trip->wait_time_end}}</span></td>
                                                         <td class="text-center"><span class="larger darker"> {{gmdate("H:i:s",$trip->wait_time)}}</span></td>
                                                          <td class="text-center"><span class="larger darker"> {{ $trip->cost_wait }}</span></td>
                                                           <td class="text-center larger darker">{{$trip->driver['name']}}</td>
                                                         <td class="text-center larger darker">{{$trip->branch['name']}}</td>
                                                </tr> 
                                    @endforeach   
                                    -->
                                                </tbody>
                                            </table>
                                            <div class="controls-below-table">
                                              {{ $alltrips->links() }}
                            <!--                <div class="table-records-info">Showing records 1 - 6</div>
                                            <div class="table-records-pages">
                                                <ul>
                                                    <li><a href="#">Previous</a></li>
                                                    <li><a class="current" href="#">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#">4</a></li>
                                                    <li><a href="#">Next</a></li>
                                                </ul>
                                            </div> -->
                                        </div>
                                        </div>
                                    </div>
                                </div>


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
                extend: 'copyHtml5',
                exportOptions: {
                    columns:[ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,13]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,13]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6,7,8,9,10,11,12,13]
                }
            },
            'colvis'
        ]
            } );
        } );
    </script>
@endsection