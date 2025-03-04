@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <h1>Create Transaction</h1>
        <form action="{{ route('admin.transaction.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="transaction_date">Transaction Date</label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control"
                    value="{{ old('transaction_date') }}">
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}"
                    placeholder="0">
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control">
                    <option value="sales" data-type="income">Sales</option>
                    <option value="booking" data-type="income">Booking</option>
                    <option value="salary" data-type="expense">Salary</option>
                    <option value="rent" data-type="expense">Rent</option>
                    <option value="utilities" data-type="expense">Utilities</option>
                    <option value="supplies" data-type="expense">Supplies</option>
                    <option value="equipment" data-type="expense">Equipment</option>
                    <option value="other" data-type="income,expense">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Transaction</button>
        </form>
    </div>
@endsection

@include('admin.blocks.froala_script')

@section('my-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const typeSelect = document.getElementById("type");
            const categorySelect = document.getElementById("category");

            function filterCategories() {
                const selectedType = typeSelect.value;
                Array.from(categorySelect.options).forEach(option => {
                    const dataType = option.getAttribute("data-type");

                    if (dataType.includes(selectedType) || dataType === "income,expense") {
                        option.hidden = false;
                    } else {
                        option.hidden = true;
                    }
                });
                if (categorySelect.selectedOptions[0].hidden) {
                    categorySelect.value = categorySelect.querySelector("option:not([hidden])").value;
                }
            }
            typeSelect.addEventListener("change", filterCategories);
            filterCategories();
        });

        new FroalaEditor('#description');
    </script>
@endsection
