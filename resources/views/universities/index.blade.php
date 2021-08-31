@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Universities') }} <a href="{{ route('universities.create') }}" class="btn btn-primary float-right">Add New</a></div>
                <div class="card-body">
                    {{-- <h2 class="mb-4">Laravel 7|8 Yajra Datatables Example</h2> --}}
                    @if ( $universities->count() > 0 )
                        <table class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $universities as $university )
                                    <tr>
                                        <td>{{ $university->name }}</td>
                                        <td>{{ $university->email }}</td>
                                        <td>@if ($university->logo)<img src="{{ asset('storage')}}/{{$university->logo }}" width="30">@endif</td>
                                        <td>{{ $university->website }}</td>
                                        <td>

                                            <form class="inline-block" action="{{ route('universities.destroy', $university->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-primary btn-sm" href="{{ route('universities.edit',$university->id) }}">Edit</a>
                                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $universities->links() !!}
                        </div>
                    @else
                        <h2 class="mb-4 text-center">No records found!</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
