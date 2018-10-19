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

<div class="wizard">

	<div class="col-md-4 col-lg-4 col-sm-4 col-xs-12 pull-left mt-5">
		<h3 class="text-left">Manage User Permission</h3>
	</div>
	<div class="col-md-8 col-lg-8 col-sm-8 col-xs-12 mt-15 pull-right">
	
		</div>

	</div>
<div class="content-fix ">
	<div class="table-responsive mb-30">
		<table class="table display" id="customers">
			<thead class="thead-dark">
				<tr>
					<th>Name</th>
					<th>User Parent Name</th>
					<th>Registered Business Name</th>
					<th>Address</th>
					<th>Business Tellphone Number</th>
					<th>Phone Number</th>
					<th>Brands</th>
					
					<th>User Role</th>
					<th>Email</th>
					<th>Actions</th>
					
				</tr>
				<tbody>
					
					@php $i=0 @endphp
					@foreach($data as $item)

						<tr>
							<td>{{$item->first_name}} {{$item->last_name}}</td>
							<td>{{$user_parent_name[$i]}}</td>
							<td>{{$item->business_name}}</td>
							<td>{{$item->business_address_line_1}}{{$item->business_address_line_2}}{{$item->city}}{{$item->state}}{{$item->country}}</td>
							<td>{{$item->business_tel_number}}</td>
							<td>{{$item->mobile_number}}</td>
							<td>{{$all_brand_name[$i]}}</td>
							
							<td>{{$item->label}}</td>
							<td>{{$item->email}}</td>
							
							<td >
								  <a href='supplieruseredit/{{$item->id}}'><button type="button" class="btn btn-default "> EDIT</button></a> 
							</td>
							
						</tr>
						
						@php $i++ @endphp
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
										Search Supplier List
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="clearfix">&nbsp;</div>
									<div class="accordionblock">
										<div class="row">
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Company:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="First Name:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Position:">
												</div>
											</div>
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Business Phone No:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Surname:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Permission Status:">
												</div>
											</div>
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Website:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Email:">
												</div>
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Status:">
												</div>
											</div>
											<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
												<div class="form-group">
													<input type="text" class="form-control" name="" placeholder="Date Created:">
												</div>
												<div class="form-group">
													&nbsp;
												</div>
												<div class="form-group">
													<button class="btn btn-default font12 mt-5 width100 p-7">APPLY FILTER</button>
												</div>
											</div>
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
			});
			$(".excel").click(function () {
				$('#customers').tableExport({
					type: 'excel',
					escape: 'false',
					tableName: 'ResolutionReport'

				});
				});
			</script>
			@endsection

