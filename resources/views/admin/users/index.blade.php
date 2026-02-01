@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1" ng-controller="userCtrl" ng-init="init()">
    <div class="">
        <div class="card card-custom">            
            <div class="card-header mt-3">
                <div class="row">
                    <div class="card-title col-md-9">
                        <h3 class="card-label">USERS</h3>
                    </div>
                    <div class="card-toolbar text-right col-md-3">
                        @if(in_array(7, $accessRights))
                            <button ng-click="addUser()" class="btn btn-info bg-gradient-info ">Add </button>
                        @endif
                    </div>
                </div>
                <hr>
            </div>
            <div class="alert alert-warning" ng-if="loading">Loading....</div> 
            <div class="card-body">

                <div class="row">

                    <div class="col-md-3 form-group" >
                        <label>User Name</label>
                        <input  type="text" placeholder="Search By User Name" class="form-control" ng-model="filter.user_name"  >
                    </div>

                    <div class="col-md-3 form-group">
                        <label>Mobile Number</label>
                        <input type="text" placeholder="Search By Mobile Number" class="form-control" ng-model="filter.mobile" >

                    </div>

                    <div class="col-md-3 form-group">
                        <label>Email</label>
                        <input type="text"  placeholder="Search By Email" class="form-control" ng-model="filter.email" >

                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-warning bg-gradient-warning  " ng-click="searchInit()" style="margin-top: 25px;">Search <i class="fa fa-search" aria-hidden="true"></i></button>
                        <button class="btn btn-secondary bg-gradient-secondary " ng-click="refresh()" style="margin-top: 25px;">Refresh <i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div table-paginate></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap  table-hover table-bordered " ng-if="dataset.length >0">
                            <thead>
                                <tr>
                                    <th style="width:50px">SN</th>
                                    <th> User Name</th>
                                    <th> Mobile No.</th>
                                    <th> Role</th>
                                    <th> Email</th>
                                    <th> Password</th>
                                    <th> #</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="user in dataset track by $index">
                                    <td>@{{ (filter.page_no - 1)*filter.max_per_page + $index + 1 }}</td>

                                    <td>@{{user.user_name}}</td>
                                    <td>@{{user.mobile}}</td>
                                    <td>@{{user.role}}</td>
                                    <td>@{{user.email}}</td>
                                    <td>@{{user.check_password}}</td>
                                    <td>
                                        <span class="ml-auto">
                                            @if(in_array(8, $accessRights))
                                                <button class="btn btn-primary bg-gradient-primary btn-sm" ng-click="editUser(user)">Edit</button>
                                            @endif
                                            @if(in_array(9, $accessRights))
                                                <button class="btn btn-danger bg-gradient-danger btn-sm"  ng-click="removeUser(user.id)" >Delete</button>
                                            @endif
                                    </span>


                                </td>
                            </tr>   


                        </tbody>
                    </table>

                    <div class="row" ng-if="dataset.length<1">
                        <div class="col-md-12 alert alert-danger">
                           No data found  !
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>


</div>
@include('admin.users.users_modal')

</div>

@endsection