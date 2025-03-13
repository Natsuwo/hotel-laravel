@extends('admin.layouts.master')

@php
    // convert collection -> array
    $settings = $settings->pluck('value', 'name')->toArray();
@endphp
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title
                        ">Settings</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.setting.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="site_name">Site Name</label>
                                <input type="text" class="form-control" id="site_name" name="name[site_name]"
                                    value="{{ old('name.site_name', $settings['site_name'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="slogan">Slogan</label>
                                <input type="text" class="form-control" id="slogan" name="name[slogan]"
                                    value="{{ old('name.slogan', $settings['slogan'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="name[description]">{{ old('name.description', $settings['description'] ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Company Phone</label>
                                <input type="phone" class="form-control" id="phone" name="name[phone]"
                                    value="{{ old('name.phone', $settings['phone'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Company Email</label>
                                <input type="email" class="form-control" id="email" name="name[email]"
                                    value="{{ old('name.email', $settings['email'] ?? '') }}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="name[address]">{{ old('name.address', $settings['address'] ?? '') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="tax">Tax (%)</label>
                                <input type="number" class="form-control" id="tax" name="name[tax]"
                                    value="{{ old('name.tax', $settings['tax'] ?? '') }}" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="vat">Vat (%)</label>
                                <input type="number" class="form-control" id="vat" name="name[vat]"
                                    value="{{ old('name.vat', $settings['vat'] ?? '') }}" step="0.01">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
