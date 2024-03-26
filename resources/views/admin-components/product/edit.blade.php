<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editProductModalLabel">Edit Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editProduct">
            <form action="" method="POST" id="editProductForm" enctype="multipart/form-data">
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
                                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
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
                    <div class="row mt-1 mb-1">
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
                                    placeholder="Stock Alert">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group">
                            <label for="product_desc">Description</label>
                            <textarea name="product_desc" id="product_desc" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control" placeholder="Choose image">
                            </div>
                            <div class="form-group">
                                <img src="" id="existingImage" alt="" class="img-thumbnail">
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id="editProductId">

                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script>
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script> -->