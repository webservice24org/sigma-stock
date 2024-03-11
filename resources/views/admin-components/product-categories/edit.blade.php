<div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-labelledby="editProductCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editProductCategoryModalLabel">Edit Product Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editProductCategory">
                <form action="" method="POST" id="editProductCategoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    <input type="hidden" name="editCategoryId" id="editCategoryId">
                </form>
            </div>

        </div>
    </div>
</div>
