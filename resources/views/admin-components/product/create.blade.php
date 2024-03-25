<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
<script src="https://cdn.tiny.cloud/1/r24p9oqicwy6ccj2ntw3q6u2jal1ex8hzk0fpu8qj7ys77ob/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createProductModalLabel">Create Prodcuct</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="createProduct">
                <form action="" method="POST" id="productForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">Product Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit_id">Product Unit</label>
                                <select name="unit_id" id="unit_id" class="form-control">
                                    <option value="">Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code">Product Code</label>
                                <input type="text" name="code" id="code" class="form-control"
                                    placeholder="Enter product code">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row mt-1 mb-1">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter product name">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type_barcode">Type Barcode</label>
                                <input type="text" name="type_barcode" id="type_barcode" class="form-control"
                                    placeholder="Enter type barcode">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="making_cost">Making Cost</label>
                                <input type="number" name="making_cost" id="making_cost" class="form-control"
                                    placeholder="Enter making cost">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="general_price">General Price</label>
                                <input type="number" name="general_price" id="general_price" class="form-control"
                                    placeholder="Enter general price">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="discount">Discount</label>
                                <input type="number" name="discount" id="discount" class="form-control"
                                    placeholder="Discount rate">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="tax_rate">Tax</label>
                                <input type="number" name="tax_rate" id="tax_rate" class="form-control"
                                    placeholder="Tax rate">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label for="stock_alert">Stock Alert</label>
                                <input type="number" name="stock_alert" id="stock_alert" class="form-control"
                                    placeholder="Tax rate">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group">
                            <label for="product_short_desc">Short Description</label>
                            <textarea name="product_short_desc" id="product_short_desc" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group">
                            <label for="product_long_desc">Long Description</label>
                            <textarea name="product_long_desc" id="product_long_desc" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-4">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control"
                                    placeholder="Choose image">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
