
 <div class="modal fade bd-example-modal-xl"  id="adduser" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@{{ (userData.id) ? "Update User" : "Add User"}}</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label>User Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control"  name="user_name" ng-model="userData.user_name" required>
                          
                            <div ng-if="!userData.user_name && userSubmitted">
                                <span class="mg-b-10 text-danger">The user name field is required.</span>
                            </div>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Mobile<span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control" ng-model="userData.mobile" required>

                            <div ng-if="!userData.mobile && userSubmitted">
                                <span class="mg-b-10 text-danger">The Mobile field is required.</span>
                            </div>
                        </div>


                        <div class="col-md-4 form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" ng-model="userData.email" required>

                            <div ng-if="!userData.email && userSubmitted">
                                <span class="mg-b-10 text-danger">The Email field is required.</span>
                            </div>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" ng-model="userData.check_password" required>

                            <div ng-if="!userData.check_password && userSubmitted">
                                <span class="mg-b-10 text-danger">The password field is required.</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 form-group">
                        
                            <label>Role <span class="text-danger">*</span></label>
                            <select class="form-control" ng-model="userData.role_id">
                                <option value="">Select</option>
                                <option ng-repeat="role in user_roles" ng-value="@{{role.id}}">@{{role.name}}</option>
                            </select>
                        </div>


                    </div>
                    <div>
                        <button class="btn btn-primary" ng-click="saveUser()" ng-disabled="ladda">@{{ (userData.id) ? "Update" : "Add"}}</button> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
  </div>
</div>  

