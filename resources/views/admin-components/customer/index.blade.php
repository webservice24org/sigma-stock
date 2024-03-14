<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="createCustomer">Create
                            Customer</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="customerTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>User Name</th>
                                <th>User Email</th>
                                <th>Category Name</th>
                                <th>Shop Name</th>
                                <th>Business Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr id="category_{{ $customer->id }}">
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->user->name }}</td>
                                    <td>{{ $customer->user->email }}</td>
                                    <td>{{ $customer->category->name }}</td>
                                    <td>{{ $customer->shopname }}</td>
                                    <td>{{ $customer->business_phone }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm editCustomer"
                                            data-id="{{ $customer->id }}">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteCustomer"
                                            data-id="{{ $customer->id }}">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="7">No customers found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
