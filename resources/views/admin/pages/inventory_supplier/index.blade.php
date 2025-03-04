@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title
                ">Suppliers
                <a href="{{ route('admin.inventory_supplier.create') }}" class="btn btn-primary float-right">Add Supplier</a>
            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>${{ $supplier->email }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>
                                <a href="{{ route('admin.inventory_supplier.edit', $supplier->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.inventory_supplier.destroy', $supplier->id) }}" method="POST"
                                    style="display: inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this supplier?');">
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
@endsection
