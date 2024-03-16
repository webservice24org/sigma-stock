@extends('layouts.admin-master')
@section('admin')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="card text-start">
        <div class="card-header">
          <h2>create quotation</h2>
        </div>
        <div class="card-body">
          <form action="{{route('quotations.store')}}" method="POST">
          @csrf
          <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group mb-2">
                <label for="date" class="pb-2">Quotation Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group mb-2">
                <label for="customer_id" class="pb-2">Select Customer</label>
                <select name="customer_id" id="customer_id" class="form-select" required>
                    <option value="disabled">Select Customer</option>
                    @foreach($customers as $item)
                        <option value="{{ $item->id }}" class="form-control">{{ $item->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group mb-2">
                <label for="warehouse_id" class="pb-2">Select Warehouse</label>
                <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                    <option value="" disabled selected>Select Warehouse</option>
                    @foreach($warehouses as $item)
                        <option value="{{ $item->id }}" class="form-control">{{ $item->warehouse_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="product_id" class="pb-2">Select Product</label>
                  <select name="product_id" id="product_id" class="form-select" required>
                    <option value="" disabled selected>Select Products</option>
                      @foreach($products as $item)
                        <option value="{{$item->id}}" class="form-control">{{$item->name}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="total_amount" class="pb-2">Total Amount</label>
                  <input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="12501" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="shipping_amount" class="pb-2">Shipping Cost</label>
                  <input type="number" class="form-control" name="total_amount" id="shipping_amount" placeholder="12501" required>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="tax_percentage" class="pb-2">Tax percentage</label>
                  <input type="number" class="form-control" name="tax_percentage" id="tax_percentage" placeholder="12501" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                <div class="form-group mb-2">
                  <label for="discount" class="pb-2">Discount</label>
                  <input type="number" class="form-control" name="discount" id="discount" placeholder="12501" required>
                </div>
              </div>
              <div class="col-md-4 col-sm-12">
                
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-12 col-sm-12">
                <label for="note">Note</label>
                <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
              </div>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-success" value="Submit">
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection