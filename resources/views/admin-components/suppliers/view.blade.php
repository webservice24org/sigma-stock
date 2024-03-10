<div class="modal fade modal-lg" id="supplierViewModal" tabindex="-1" aria-labelledby="supplierViewModallLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
            <h1 class="modal-title fs-5" id="supplierViewModalModalLabel">Supplier Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="supplierViewModalBody">
        <form action="" method="GET" id="viewSupplierForm">
          <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="created_by">Added By</label>
                  <input type="text" name="created_by" id="created_by" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="supplierId">Supplier ID</label>
                  <input type="text" name="supplierId" id="supplierId" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="status">Supplier Status</label>
                  <input type="text" name="status" id="status" class="form-control">
                </div>
              </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                  <label for="user_photo">Supplier Photo</label>
                  <img src="" name="user_photo" id="user_photo" style="width:100px; height:100px"/>
              </div>
              
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="user_id">Supplier Name</label>
                <input type="text" name="user_id" id="user_id" class="form-control">
              </div>
              
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="form-group">
                <label for="user_mail">Supplier Email</label>
                <input type="text" name="user_mail" id="user_mail" class="form-control">
              </div>
              
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label for="shopname">Shop Name</label>
                <input type="text" name="shopname" id="shopname" class="form-control" disabled>
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                  <label for="trade_license">Trade License No</label>
                  <input type="text" name="trade_license" id="trade_license" class="form-control">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                  <label for="business_phone">Business Phone</label>
                  <input type="text" name="business_phone" id="business_phone" class="form-control">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                  <label for="user_phone">Supplier Mobile</label>
                  <input type="text" name="user_phone" id="user_phone" class="form-control">
              </div>
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="address">Supplier Address</label>
                <input type="text" name="address" id="address" class="form-control">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="text" name="dob" id="dob" class="form-control">
              </div>
            </div>
            <div class="col-md-3 col-sm-12">
              <div class="form-group">
                <label for="nid">Nid</label>
                <input type="text" name="nid" id="nid" class="form-control">
              </div>
            </div>
          </div>
            
            <div class="row">
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="bank_name">Bank Name</label>
                  <input type="text" name="bank_name" id="bank_name" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="account_holder">Account Holder</label>
                  <input type="text" name="account_holder" id="account_holder" class="form-control">
                </div>
              </div>
               <div class="col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="account_number">Account Number</label>
                  <input type="text" name="account_number" id="account_number" class="form-control">
                </div>
              </div>
              
            </div>
            
            
            <div class="form-group">
                <label for="note">Note</label>
                <textarea class="form-control" name="note" id="note" cols="20" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printSupplier">Print</button>
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <input type="hidden" name="supplierId" id="supplierId">
        </form>

      </div>
      
    </div>
  </div>
</div>