@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Edit User')
@section('admin')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="float-start">Edit User</h2>
                <a href="{{ route('users.index') }}" class="btn btn-primary float-end">User List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <div class="form-group mb-2">
                        <label for="name">User Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small>Leave blank if you don't want to change the password.</small>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="profile_photo_path">Picture</label>
                        <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control">
                        <input type="hidden" name="old_profile_photo_path" value="{{ $user->profile_photo_path }}">
                        @if($user->profile_photo_path)
                            <img src="{{ asset($user->profile_photo_path) }}" id="picturePreView" alt="Profile Photo" width="100" height="100">
                        @endif
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
