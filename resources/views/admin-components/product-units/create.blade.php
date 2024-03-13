<div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createUnitModalLabel">Add New Product Unit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="productUnit">
        <form action="" method="POST" id="unitForm">
            @csrf
            <div class="form-group mb-2">
                <label for="unit_name pb-2">Product Unit Name</label>
                <input type="text" name="unit_name" id="unit_name" class="form-control">
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