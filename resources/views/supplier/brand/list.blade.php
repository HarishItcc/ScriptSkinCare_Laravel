@extends('supplier.suppliermaster')
@section('content')
<div class="wizard spcust">
    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 pull-left">
        <h3 class="text-left mt-20">Manage Brands</h3>
    </div>
    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12 mt-15 text-right">
        <!-- <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
            <button type="button" class="btn btn-green m-l-5 btn-block"> SORT / ARRANGE BY</button>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
            <div class="dropdown export">
                <button class="btn btn-default m-l-5 btn-block btn-transparent dropdown-toggle" type="button" data-toggle="dropdown">EXPORT DATA OPTIONS
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu"> -->
                        <!-- <li><a href="#">Export PDF</a></li> -->
                        <!-- <li><a href="javascript:void(0)"  onClick ="$('#customers').tableExport({type:'excel',escape:'false',tableName:'yourTableName'});">Export Excel</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                <button type="button" class="btn btn-green m-l-5 btn-block"> + ADD NEW SUPPLIER</button>
            </div> -->
        </div>
    </div>
    <div class="content-fix ">
        <div class="table-responsive mb-30">
            <table class="table display" id="customers">
                <thead class="thead-dark">
                    <tr>
                        <th>Brand Name</th>
                        <th>Registered Business Name</th>
                        <th >Brand Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>

                        <td>{{$item->brand_name}}</td>
                        <td>{{$item->business_name}}</td>        
                        <td>
                            <img class="img-responsive" style="width:50px; " src="{{asset('public/images/brand')}}/{{$item->brand_logo}}">
                        </td>
                        <td >
                            <a href='supplier-brandedit/{{$item->id}}' data-id={{$item->id}}>
                                <button type="button" class="btn btn-default "> EDIT</button>
                            </a> 
                        </td>
                    </tr>                                
                    @endforeach                             
                </tbody>
            </table>
        </div>
    </div>
    <div id="footer">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Search Manage Brands List
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="clearfix">&nbsp;</div>
                                <div class="accordionblock">
                                    <div class="row">

                                        <form action="{{ url('/supplier-brand-list') }}" method="post">
                                            @csrf
                                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="business_name" placeholder="Company:" value="{{ !empty($request->business_name) ? $request->business_name : '' }}">
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="brand_name"  value="{{ !empty($request->brand_name) ? $request->brand_name : '' }}" placeholder="Brands Name:">
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">


                                                <div class="form-group">
                                                    <select class="form-control" name="status">
                                                        <option value="">Select Status</option>
                                                        <option value="0"{{ isset($request->status)?($request->status==0 ? 'selected' : ''):('') }} >Active</option>
                                                        <option value="1"{{ isset($request->status)?($request->status== 1 ? 'selected' : ''):('') }} >Deactive</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control datepicker"  name="create_date"  value="{{ !empty($request->create_date) ? $request->create_date : '' }}" placeholder="Date Created:" readonly="">
                                                </div>

                                                <div class="form-group">
                                                    <button class="btn btn-default font12 mt-5 width100 p-7">APPLY FILTER</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#customers').DataTable();
        } );

        $(document).on("click", ".deactivaterow", function(event) {
            event.preventDefault();
            var id = $(this).attr('data-id');
            var msg = $(this).attr('msg');
            var status = 0;
            if(msg == 'Deactivate') {
                status = 1;
            }
            swal({
                title: 'Are you sure?',
                text: "You want to "+msg+"!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, '+msg+'',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10',
                buttonsStyling: false
            }).then(function () {
        // call ajax function to delete it
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_mytoken"]').attr('content')
            }
        });

        $.ajax({
            type: "GET",
            url: "<?php echo url('/customeractivedeactive')?>/"+id+"/"+status,
            success: function(data) {             
                swal({
                    title: msg+'!',
                    text: 'Customer has been '+msg+'.',
                    type: 'success'
                }).then(function() {
                    location.reload();
                });
            },
            error: function() {
                alert('error');
            }
        })
    }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
    })

        })
    </script>
@endsection
@section('scripts')
@include('layouts.datatablejs')
@endsection