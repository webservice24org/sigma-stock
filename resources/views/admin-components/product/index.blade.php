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
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Making Cost</th>
                                <th>General Price</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                                <tr id="product_{{ $product->id }}">
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->making_cost }}</td>
                                    <td>{{ $product->general_price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:void(0)" class="btn btn-success btn-sm mx-2 editProduct"
                                                data-id="{{ $product->id }}">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteProduct"
                                                data-id="{{ $product->id }}">Delete</a>
                                        </div>
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
