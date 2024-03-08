<div class="modal fade" id="createCustomerCategoryModal" tabindex="-1" aria-labelledby="createCustomerCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createCustomerCategoryModalLabel">Create Customer Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="createCustomerCateogry">
        <form action="" method="POST" id="customerCategoryForm">
            @csrf
            <div class="form-group">
                <label for="cat_name">Category Name</label>
                <input type="text" name="cat_name" id="cat_name" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>