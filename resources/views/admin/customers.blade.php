@extends('layouts.master')
@section('content')
<style type="text/css">
.pagination > li > a, .pagination > li > span {
    border-radius: 0; 
}

</style>
<script type="text/javascript" src="{{ asset('assets/js/2jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/3dataTables.bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/export-sheet/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/export-sheet/jquery.base64.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/export-sheet/jspdf/libs/sprintf.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/export-sheet/jspdf/jspdf.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/export-sheet/jspdf/libs/base64.js') }}"></script>

<div class="wizard spcust">
    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 pull-left">
        <h3 class="text-left mt-20">Search Customers</h3>
    </div>
    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12 mt-15 text-right">
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
            <button type="button" class="btn btn-green m-l-5 btn-block"> SORT / ARRANGE BY</button>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-6">
            <div class="dropdown export">
                <button class="btn btn-default m-l-5 btn-block btn-transparent dropdown-toggle" type="button" data-toggle="dropdown">EXPORT DATA OPTIONS
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <!--<li><a href="#">Export PDF</a></li>-->
                        <li><a href="javascript:void(0)"  onClick ="$('#customers').tableExport({type:'excel',escape:'false',tableName:'yourTableName'});">Export Excel</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                <button type="button" class="btn btn-green m-l-5 btn-block"> + ADD NEW SUPPLIER</button>
            </div>
        </div>
    </div>
    <div class="content-fix ">
        <div class="table-responsive mb-30">
            <table class="table display" id="customers">
                <thead class="thead-dark">
                    <tr>
                        <th>User Details</th>
                        <th>Gender</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Signup Source</th>
                        <th>Registered By</th>
                        <th>Recent Skin Type</th>
                        <th>Recent Skin Concern</th>
                        <th>Average Spend</th>
                        <th>Overall Spend</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>
                            <b> Name: </b><span class="text-purple">{{$item->first_name}} {{$item->last_name}}</span>
                            <br> 
                            <b>Email: </b><span class="text-custom">{{$item->email}}</span>
                            <br> 
                            <b>Age: </b> {{ date_diff(date_create($item->dob), date_create('today'))->y}}
                        </td>
                        <td>{{$item->gender}}</td>
                        <td>{{date("d-m-Y", strtotime($item->created_date))}}</td>
                        <td>{{$item->status==0 ? 'Active' : 'Deactive'}}</td>
                        <td>{{$item->signup_source}}</td>
                        <td>{{$item->created_by}}</td>
                        <td>{{$item->skin_type}}</td>
                        <td>{{$item->skin_concerns}}</td>
                        <td></td>
                        <td></td>                    
                        <td class="flex">
                            <a href='customeredit/{{$item->id}}' data-id={{$item->id}}><button type="button" class="btn btn-default "> VIEW</button></a> 
                            <a href='javascript:void()' class='deactivaterow' msg="{{$item->status==1 ? 'Activate' : 'Deactivate'}}" data-id={{$item->id}}><button class="btn btn-default m-l-5">{{$item->status==1 ? 'ACTIVATE' : 'DEACTIVATE'}}</button></a>
                        </td>
                    </tr>                                
                    @endforeach                             
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer p-10">
        <div class="conatiner text-center">
            <div class="row">
                <div class="col-md-1 col-sm-1">&nbsp;</div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                    <div class="col-md-12 text-center mt-20 mb-10">
                        <a href="{{ route('customeradd') }}" class="btn btn-light spbtn">
                            + ADD A NEW CUSTOMER
                        </a>
                    </div>
                </div>
                <div class="col-md-1 col-sm-1">&nbsp;</div>
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

