@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Create Transaction</h1>
        <form action="{{ route('admin.transaction.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="transaction_date">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                    value="{{ $record->transaction_date }}">
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ $record->amount }}"
                    placeholder="0">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="income" {{ $record->type == 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ $record->type == 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" class="form-control" value="{{ $record->category }}"
                    placeholder="Salary">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ $record->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Transaction</button>
        </form>
    </div>
@endsection
@include('admin.blocks.froala_script')
@section('my-script')
    <script>
        new FroalaEditor('#description');
    </script>
@endsection
