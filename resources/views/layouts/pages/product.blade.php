@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Products')
@section('admin')
    @include('admin-components.product.index')
    @include('admin-components.product.create')
    @include('admin-components.product.edit')
@endsection

@push('js')
    <script>
        const productRowCount = {{ $products->count() }};
    </script>
    <script src="{{ asset('assets/admin/js/product.js') }}"></script>
@endpush
