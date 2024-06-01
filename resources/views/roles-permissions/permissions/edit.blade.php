@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Edit Permission')
@section('admin')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="float-start">Edit Permission</h2>
                <a href="{{ route('permissions.index') }}" class="btn btn-primary float-end">Permission List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
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
