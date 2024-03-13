<div class="modal fade" id="editPurchaseCatModal" tabindex="-1" aria-labelledby="editPurchaseCatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editPurchaseCatModalLabel">Edit Purchase Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editPurchaseCat">
        <form action="" method="POST" id="editpurchaseCatForm">
            @csrf
            <div class="form-group mb-2">
                <label for="purchase_cat_name pb-2">Purchase Category Name</label>
                <input type="text" name="purchase_cat_name" id="purchase_cat_name" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <input type="hidden" name="purchaseCatId" id="purchaseCatId">
        </form>
      </div>
      
    </div>
  </div>
</div>