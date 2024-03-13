<div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editUnitModalLabel">Edit Product Unit</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="editproductUnit">
        <form action="" method="POST" id="editUnitForm">
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
        <input type="hidden" name="unitId" id="unitId">
      </div>
      
    </div>
  </div>
</div>