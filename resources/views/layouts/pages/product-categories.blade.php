@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Product Categories')
@section('admin')
    @include('admin-components.product-categories.index')
    @include('admin-components.product-categories.create')
    @include('admin-components.product-categories.edit')

@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/product-categories.js') }}"></script>
@endpush
