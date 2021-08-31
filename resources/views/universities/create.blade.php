@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add University') }}</div>
                <div class="card-body">
                    {{-- <h2 class="mb-4">Laravel 7|8 Yajra Datatables Example</h2> --}}
                    <form method="POST" action="{{ route('universities.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 required">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" value="{{ old('name', '') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="emai" placeholder="Enter Email" value="{{ old('email', '') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="website">Website</label>
                                <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" placeholder="Enter Website" value="{{ old('website', '') }}">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" class="form-control-file @error('logo') is-invalid @enderror" id="logo">
                                <small id="emailHelp" class="form-text text-muted">Image dimentions should be 100 x 100.</small>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
