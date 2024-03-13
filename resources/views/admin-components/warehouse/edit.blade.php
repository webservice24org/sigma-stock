<div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editWarehouseModalLabel">Edit Warehouse</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="warehouse">
        <form action="" method="POST" id="editWarehouseForm">
            @csrf
            <div class="form-group mb-2">
                <label for="warehouse_name pb-2">Warehouse Name</label>
                <input type="text" name="warehouse_name" id="warehouse_name" class="form-control">
            </div>
            <div class="form-group mb-2">
                <label for="warehouse_address pb-2">Warehouse Address</label>
                <textarea name="warehouse_address" id="warehouse_address" cols="20" rows="7" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <input type="hidden" name="warehouseId" id="warehouseId">
        </form>
      </div>
      
    </div>
  </div>
</div>