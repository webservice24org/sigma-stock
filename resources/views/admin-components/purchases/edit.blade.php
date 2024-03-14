<div class="modal fade modal-lg" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editPurchaseModalLabel">Edit Purchase Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editPurchase">
        <form action="" method="POST" id="updatePurchaseForm">
            @csrf
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="supplier_id" class="pb-2">Select Supplier</label>
                  <select name="supplier_id" id="supplier_id" class="form-select" aria-label="Default select example">
                      <option value="" selected disabled>Select Supplier</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                  <div class="form-group mb-2">
                    <label for="warehouse_id" class="pb-2">Select WareHouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-select" aria-label="Default select example">
                        <option value="" selected disabled>Select WareHouse</option> 
                    </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="purchase_category_id" class="pb-2">Select Purchase Category</label>
                  <select name="purchase_category_id" id="purchase_category_id" class="form-select" aria-label="Default select example">
                      <option value="" selected disabled>Select Category</option>  
                  </select>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              
              <div class="col-md-3 col-sm-12">
                <div class="form-group mb-2">
                  <label for="unit_id" class="pb-2">Select Purchase Unit</label>
                  <select name="unit_id" id="unit_id" class="form-select" aria-label="Default select example">
                      <option value="" selected disabled>Select Unit</option> 
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-sm-12">
                <div class="form-group mb-2">
                  <label for="purchase_qty" class="pb-2">Purchase Quantity</label>
                  <input type="number" required id="purchase_qty" name="purchase_qty" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="date" class="pb-2">Purchase Date</label>
                  <input type="date" required name="date" id="date" class="form-control">
                </div>
              </div>
              <div class="col-md-2 col-sm-12">
                  <div class="form-group mb-2">
                    <label for="tax_rate" class="pb-2">Tax Rate</label>
                    <input type="number" required required name="tax_rate" id="tax_rate" class="form-control">
                  </div>
              </div>
            </div>
            
            <div class="row">
              
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="payment_statut" class="pb-2">Payment Status</label>
                  <select name="payment_statut" id="payment_statut" class="form-select" aria-label="Default select example">
                      <option value="0">Partial</option> 
                      <option value="1">Full Paid</option> 
                  </select>
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="grand_total" class="pb-2">Total Amount</label>
                  <input type="number" required id="grand_total" name="grand_total" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="paid_amount" class="pb-2">Paid Amount</label>
                  <input type="number" required id="paid_amount" name="paid_amount" class="form-control">
                </div>
              </div>

            </div>
            <div class="row">
              
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="discount" class="pb-2">Discount Amount</label>
                  <input type="number" required id="discount" name="discount" class="form-control">
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="due_amount" class="pb-2">Due Amount</label>
                  <input type="number" required id="due_amount" name="due_amount" class="form-control">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="shipping_cost" class="pb-2">Shipping Cost</label>
                  <input type="number" required id="shipping_cost" name="shipping_cost" class="form-control">
                </div>
              </div>

            </div>

            <div class="form-group mb-2">
                <label for="notes">Note</label>
                <textarea class="form-control" name="notes" id="notes" cols="20" rows="5"></textarea>
            </div>
            <div class="modal-footer mb-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <input type="hidden" name="purchaseId" id="purchaseId">
        </form>
      </div>
      
    </div>
  </div>
</div>