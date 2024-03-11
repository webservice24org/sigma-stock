<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="javascript:void(0)" class="btn btn-primary" id="createProduct">Create
                            Product</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Type Barcode</th>
                                <th>Making Cost</th>
                                <th>General Price</th>
                                <th>Unit</th>
                                <th>Discount</th>
                                <th>Tax Rate</th>
                                <th>Note</th>
                                <th>Stock Alert</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr id="product_{{ $product->id }}">
                                    <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->type_barcode }}</td>
                                    <td>{{ $product->making_cost }}</td>
                                    <td>{{ $product->general_price }}</td>
                                    <td>{{ $product->unit_id }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->tax_rate }}</td>
                                    <td>{{ $product->note }}</td>
                                    <td>{{ $product->stock_alert }}</td>
                                    <td>{{ $product->createdBy->name }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm mx-2 editProduct"
                                                data-id="{{ $product->id }}">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteProduct"
                                                data-id="{{ $product->id }}">Delete</a>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="14">No Product Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
