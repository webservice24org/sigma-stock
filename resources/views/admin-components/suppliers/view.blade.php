<div class="modal fade" id="supplierViewModal" tabindex="-1" aria-labelledby="supplierViewModallLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="supplierViewModalModalLabel">Add New Supplier</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="supplierViewModalBody">
        <form action="" method="GET" id="viewSupplierForm">
            @csrf
            <div class="form-group">
                <label for="user_id">Select User</label>
                <input type="text" name="user_id" id="user_id" class="form-control">
              </div>
              <div class="form-group">
                <label for="created_by">Created By</label>
                <input type="text" name="created_by" id="created_by" class="form-control">

              </div>
            <div class="form-group">
                <label for="shopname">Shop Name</label>
                <input type="text" name="shopname" id="shopname" class="form-control">
            </div>
            <div class="form-group">
                <label for="trade_license">Trade License No</label>
                <input type="text" name="trade_license" id="trade_license" class="form-control">
            </div>
            <div class="form-group">
                <label for="business_phone">Business Phone</label>
                <input type="text" name="business_phone" id="business_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea class="form-control" name="note" id="note" cols="20" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <input type="hidden" name="supplierId" id="supplierId">
        </form>

      </div>
      
    </div>
  </div>
</div>