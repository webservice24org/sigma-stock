@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Edit Role')
@section('admin')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="float-start">Edit Role</h2>
                <a href="{{ route('roles.index') }}" class="btn btn-primary float-end">Role List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
