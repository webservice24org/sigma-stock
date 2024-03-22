@extends('layouts.admin-master')
@section('admin')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2>All Quotation Details</h2>
                    </div>
                    <div class="col-md-3 text-end">
                        <a href="{{route('quotations.create')}}" class="btn btn-primary" id="quotationCreate">Create Quotation</a>

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-bordered" id="supplierTable">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Customer Name</th>
                                <th>Quotation Date</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotations as $item)
                                <tr id="quotation_{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->customer->user->name}}</td>
                                    <td>{{$item->date}}</td>
                                    <td>{{$item->total_amount}}</td>
                                    <td>{{$item->discount}}</td>
                                    <td>
                                    <a href="{{ route('quotations.show', ['quotation' => $item->id]) }}" class="btn btn-success viewQuotation" data-id="{{ $item->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                        <a href="{{ route('quotations.edit', ['quotation' => $item->id]) }}" class="btn btn-primary editQuotation" data-id="{{$item->id}}"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="" class="btn btn-danger deleteQuotation" data-id="{{$item->id}}"><i class="fa-solid fa-trash-can"></i></a>
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
@endsection