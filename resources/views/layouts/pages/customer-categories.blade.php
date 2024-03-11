@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Customer Categories')
@section('admin')
    @include('admin-components.customer-categories.index')
    @include('admin-components.customer-categories.create')
    @include('admin-components.customer-categories.edit')

@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/customer-categories.js') }}"></script>
@endpush
