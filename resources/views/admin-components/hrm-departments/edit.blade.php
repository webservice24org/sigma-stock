<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editDepartmentModalLabel">Edit Department</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="department">
        <form action="" method="POST" id="editDepartmentForm">
            @csrf
            <div class="form-group">
                <label for="department_name pb-2">Department Name</label>
                <input type="text" name="department_name" id="department_name" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            <input type="hidden" id="departmentId" name="departmentId">
        </form>
      </div>
      
    </div>
  </div>
</div>