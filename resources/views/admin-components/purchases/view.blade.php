<div class="modal fade modal-lg" id="viewPurchaseModal" tabindex="-1" aria-labelledby="viewPurchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewPurchaseModalLabel">Purchase Details</h1>
        <h3 class="text-center fs-5 ps-5 text-capitalize">Added by: <span id="user_name" class="text-success fw-bold"></span></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="viewPurchase">
        <form action="" method="POST" id="viewPurchaseForm">
            @csrf
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="supplier_id" class="pb-2">Supplier Shop</label>
                  <input type="text" name="supplier_id" id="supplier_id">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                  <div class="form-group mb-2">
                    <label for="warehouse_id" class="pb-2">Purchased for</label>
                    <input type="text" name="warehouse_id" id="warehouse_id">
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="purchase_category_id" class="pb-2">Purchase Category Name</label>
                  <input type="text" name="purchase_category_id" id="purchase_category_id">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              
              <div class="col-md-3 col-sm-12">
                <div class="form-group mb-2">
                  <label for="unit_id" class="pb-2">Purchase Unit</label>
                  <input type="text" name="unit_id" id="unit_id">
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
                    <label for="tax_rate" class="pb-2">Tax Rate %</label>
                    <input type="number" required required name="tax_rate" id="tax_rate" class="form-control">
                  </div>
              </div>
            </div>
            
            <div class="row">
              
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="payment_statut" class="pb-2">Payment Status</label>
                  <input type="text" required required name="payment_statut" id="payment_statut" class="form-control">
                </div>
              </div>

              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="payment_statut" class="pb-2">Total Amount</label>
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
                <button type="button" class="btn btn-primary" id="printPurchase">Print</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>