@extends('layouts.admin-master')
@section('admin')
    @include('admin-components.suppliers.index')
    @include('admin-components.suppliers.create')
    @include('admin-components.suppliers.view')
    @include('admin-components.suppliers.edit')
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/suppliers.js') }}"></script>
@endpush
