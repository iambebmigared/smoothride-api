@extends('layouts.bm')
 
@section('title')
Regional Breakdown
@endsection
 @section('css')
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />


@endsection
@section('content')
<div class="row">
    <div class="col-md-4">
    <h4>Regional Breakdown</h4>
</div>
</div>
 
<!-- <div class="row">
   
                <div class="col-md-4">
                     <form action="{{route('dashboard.searchtrip')}}" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                    <div class="form-group">
                     <span>From:</span>  <input type="date" name="first" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                  <span>To:</span>  <input type="date" name="second" class="form-control">
                </div>
                <div class="col-md-4">
                     <div class="form-group" align="center">
                        <button type="submit" name="filter" id="filter" class="btn btn-info">Filter</button>
                    </form>
                <a href="{{route('dashboard.getallcompletedtrips')}}" class="btn btn-default">Reset</a>
                    </div>
                </div>
                <div class="col-md-8 text-center text-danger mb-3 font-weight-bold">
                    @if($errors->first()!=null)
                        Please fill at least one field
                    @endif
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-12">
                    <h4 class="text-center text-secondary">
                        @if (\Session::has('msg'))
                            {!! \Session::get('msg') !!}
                        @endif
                    </h4>
                </div-col-md-12>
                    
        
</div>-->
 <div class="element-wrapper">
                                    <div class="element-box">
                                        <div style="overflow-x: scroll; width: 90%" class="table-responsive" >
                                            <table id ="example" class="table table-lightborder" class="datatable mdl-data-table dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>Region's Name</th>
                                                        <th class="text-center">Total Trip Amount</th>
                                                        <th class="text-center">Total Trip Count</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    @foreach($d_regions as $d_region)
                                                    <tr>
                                                        <td>
                                                            <div class="user-with-avatar"><span class="d-none d-xl-inline-block smaller lighter">{{$d_region['region']}}</span></div>
                                                        </td>
                                                       
                                                        <td class="text-center"><span class="smaller lighter">{{$d_region['tripAmt']}}</span></td>
                                                         <td class="text-center"><span class="smaller lighter">{{$d_region['tripCount']}}</span></td>
                                       
                                                </tr> 
                                    @endforeach   
                                                    
                                                </tbody>
                                            </table>
                                            <div class="controls-below-table">
                                               
                                              
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
                    columns:[ 0, 1, 2,3,4, 5,6,7]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6,7]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4, 5,6,7]
                }
            },
            'colvis'
        ]
            } );
        } );
    </script> 
@endsection