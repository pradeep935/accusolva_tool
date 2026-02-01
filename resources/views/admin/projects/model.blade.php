
 <div class="modal fade bd-example-modal-xl"  id="changeStatus" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Change Status</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                    <form ng-submit="saveChangeStatus(addForm.$valid)" name="addForm" novalidate="novalidate">

                        <div class="row">
                            
                            <div class="col-md-10 form-group">
                            
                                <label>Status</label>
                                <select class="form-control" ng-model="statusData.status_id" convert-to-number>
                                    <option ng-repeat="status in statusOptions" value="@{{status.value}}">@{{status.label}}</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" style="margin-top:25px;" class="btn btn-primary">Submit</button> 
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
  </div>
</div>  

