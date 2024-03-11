@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Customers')
@section('admin')
    @include('admin-components.customer.index')
    @include('admin-components.customer.create')
    @include('admin-components.customer.edit')
@endsection

@push('js')
    <script>
        const customerRowCount = {{ $customers->count() }};
    </script>
    <script src="{{ asset('assets/admin/js/customer.js') }}"></script>
@endpush
