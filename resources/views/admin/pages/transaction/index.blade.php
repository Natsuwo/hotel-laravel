@extends('admin.layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title
                ">Transactions
                <a href="{{ route('admin.transaction.create') }}" class="btn btn-primary float-right">Add Transaction</a>

            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>${{ $transaction->amount }}</td>
                            <td>
                                <span class="badge {{ $transaction->type == 'income' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td>{{ $transaction->category }}</td>
                            <td>{!! $transaction->description !!}</td>
                            <td>
                                <a href="{{ route('admin.transaction.edit', $transaction->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.transaction.destroy', $transaction->id) }}" method="POST"
                                    style="display: inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this transaction?');">
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
