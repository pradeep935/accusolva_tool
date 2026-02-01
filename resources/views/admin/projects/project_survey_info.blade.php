@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1" ng-controller="projectDetailCtrl" ng-init="init({{$project_id}},{{$status}})">
	<div class="">
        <div class="card card-custom">            
            <div class="card-header">
                <div class="card-title">
                	<div class="row">
                		<div class="col-md-8">
                    		<h3 class="card-label">View Project Survey Details</h3>
                		</div>
                	</div>
                	<hr>
                </div>
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-md-3 form-group" >
                        <label>Suplier ID </label>
						<input type="text" class="form-control" ng-model="filter.gid"  >
                    </div>

                    <div class="col-md-3 form-group">
						<label>Status</label>
						<select class="form-control" ng-model="filter.status">
							<option value="">Select</option>
							<option ng-repeat="status in surveyStatusOptions" ng-value="@{{status.value}}">@{{status.label}}</option>
						</select>
					</div>
					<div class="col-md-3 form-group">
						<label>Country</label>
						<select class="form-control" ng-model="filter.country_id">
							<option value="">Select</option>
							<option ng-repeat="country in countries" ng-value="@{{country.id}}">@{{country.name}}</option>
						</select>
					</div>

                    <div class="col-md-3" style="margin-top : 25px;">
                        <button class="btn  btn-primary" ng-click="searchData()" >Search <i class="fa fa-search" aria-hidden="true"></i></button>

                         <a class="btn  btn-success" ng-click="refresh()" >Refresh <i class="fa fa-refresh" aria-hidden="true"></i></a>

                         <a class="btn  btn-warning" ng-click="exportExcel()" ng-disabled="export">Export <div class="spinner-border spinner-border-sm" role="status" ng-show="export"></div></a>
                    </div>

                </div>

            </div>
        </div>
    </div>
	<div class="alert alert-info" ng-if="loading">Loading....</div>
	<div class="row row-sm ">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header pb-0">
					<div table-paginate></div>
				</div>
				<div class="card-body">
					<div class="table-responsive ">
						<table class="table table-hover table-bordered">
							<thead>
								<tr>
									<th>SN</th>
									<th>ID</th>
									<th>Suplier ID</th>
									<th>Suplier Name</th>
									<th>Our po</th>
									<th>Client</th>
									<th>Start IP</th>
									<th>End IP </th>
									<th>Start Time</th>
									<th>End Time </th>
									<th>Start Date</th>
									<th>End Date </th>
									<th>Ref Id</th>
									<th>UID</th>
									<th>Loi</th>
									<th>Status</th>
									<th>Country</th>
									
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="project in dataset track by $index">
									<td>@{{ (filter.page_no - 1)*filter.max_per_page+$index+1 }}</td>
									<td>@{{project.pid}}</td> 
									<td>@{{project.gid}}</td> 
									<td>@{{project.vendorName ? project.vendorName : "Internal Team"}}</td> 
									<td>@{{project.project_name}}</td>
									<td>@{{project.clientName}}</td>
									<td>@{{project.start_ip_address}}</td>
									<td>@{{project.end_ip_address ? project.end_ip_address : project.start_ip_address}}</td>
									<td>@{{project.start_time}}</td>
									<td>@{{project.end_time}}</td>
									<td>@{{project.start_date}}</td>
									<td>@{{project.end_date}}</td>
									<td>@{{project.ref_id}}</td>
									<td>@{{project.user_id}}</td>
									<td>@{{project.loi}}</td>
									<td>@{{project.status}}</td>
									<td>@{{project.country_name}}</td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

					
	</div>

</div>

@endsection