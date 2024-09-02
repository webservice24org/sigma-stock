@extends('layouts.admin-master')
@section('title', 'Admin Dashboard || Permissions')
@section('admin')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="float-start">All Permissoins</h2>
                    <a href="{{route('permissions.create')}}" class="btn btn-primary float-end">Add Permission</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="permissionTable">
                        <thead>
                            <tr>
                                <th>Permission ID</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $item)
                            <tr id="permission_{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    
                                    <a href="{{ route('permissions.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('permissions.destroy', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>


                                    
                                </td>
                            </tr>
                        @endforeach
                                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

@endsection
    
