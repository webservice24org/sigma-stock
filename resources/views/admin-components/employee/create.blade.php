<div class="modal fade" id="createEmployeeModal" tabindex="-1" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createEmployeeModalLabel">Add New Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="employee">
        <form action="" method="POST" id="employeeForm">
            @csrf
            <div class="form-group mb-2">
                <label for="user_id">Select User</label>
                <select name="user_id" id="user_id" class="form-select" aria-label="Default select example">
                    <option value="" selected disabled>Select User</option>
                    @foreach ($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="hrm_department_id">Select Department</label>
                <select name="hrm_department_id" id="hrm_department_id" class="form-select" aria-label="Default select example">
                    <option value="" selected disabled>Select Department</option>
                    
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="salary_amount">Salary Amount</label>
                <input type="text" name="salary_amount" id="salary_amount" class="form-control">
            </div>
            <div class="form-group mb-2">
                <label for="joining_date">Joining Date</label>
                <input type="date" name="joining_date" id="joining_date" class="form-control">
            </div>
            <div class="form-group mb-2">
                <label for="note">Note</label>
                <textarea class="form-control" name="note" id="note" cols="20" rows="5"></textarea>
            </div>
            <div class="modal-footer mb-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>