<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="createProductCategory">Create
                            Category</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="productCategoryTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Product Category</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr id="category_{{ $item->id }}">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->createdBy->name }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-success editCategory"
                                            data-id="{{ $item->id }}">Edit</a>
                                        <a href="javascript:void(0)" class="btn btn-danger deleteCategory"
                                            data-id="{{ $item->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
