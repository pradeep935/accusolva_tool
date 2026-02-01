@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1">
	

	<div class="row row-sm ">

		<div class="col-xl-12">
        <div class="card card-custom">            
            <div class="card-header mt-3">
            	<div class="row">
	            	<div class="card-title col-md-9">
	                    <h3 class="card-label">Clients</h3>
	                </div>
	                <div class="card-toolbar text-right col-md-3">
                        @if(in_array(11, $accessRights))
							<a href="{{url('/clients/add')}}" class="btn  btn-info bg-gradient-info ">Add </a>
						@endif
	                    

	                </div>
            		
            	</div>
                
                
            </div>
            <div class="alert alert-warning" ng-if="loading">Loading....</div> 
        </div>
    </div>
		<div class="col-xl-12">
			<div class="card mg-b-20">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between">
						<h4 class="card-title mg-b-0 mt-2">All Clients</h4>
						<i class="mdi mdi-dots-horizontal text-gray"></i>
					</div>
					@if(Session::has('message'))
			            <div class="alert alert-danger">
			              <i class="fa fa-ban-circle"></i><strong>message!</strong> {{Session::get('message')}}
			            </div>
			         @endif
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="table key-buttons text-md-nowrap  table-hover table-bordered " >
							<thead>
								<tr>
                					<th class="border-bottom-0">SN</th>
									<th class="border-bottom-0">Name</th>
									<th class="border-bottom-0">Email</th>
									<th class="border-bottom-0">Contact Person</th>
									<th class="border-bottom-0">Number</th>
									<th class="border-bottom-0">Payment Term</th>
									<th class="border-bottom-0">#</th>
								</tr>
							</thead>
							<tbody>


	        					@foreach($clients as $key => $client)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$client->clientName}}</td>
									<td>{{$client->email}}</td>
									<td>{{$client->contactPerson}}</td>
									<td>{{$client->contact}}</td>
									<td>{{$client->paymentTerms}}</td>
									<td>
										<span class="ml-auto">
                        					@if(in_array(12, $accessRights))
												<a href="{{ url('clients/add/'.$client->id) }}" class="btn btn-sm btn-primary bg-gradient-primary ">Edit</a>
											@endif

                        					@if(in_array(13, $accessRights))

												<a href="{{ url('clients/delete/'.$client->id) }}" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm bg-gradient-danger ">Delete</a>
											@endif
										</span>
									</td>
								</tr>
								@endforeach
								

							</tbody>
						</table>

						<!-- <div class="row" ng-if="dataset.length<1">
	                        <div class="col-md-12 alert alert-danger">
	                                 No data found  !
	                        </div>
	                    </div> -->
					</div>
				</div>
			</div>
		</div>

					
	</div>
	@include('admin.users.users_modal')

</div>

@endsection