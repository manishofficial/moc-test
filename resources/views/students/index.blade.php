@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Students') }} <a href="{{ route('students.create') }}" class="btn btn-primary float-right">Add New</a></div>
                <div class="card-body">
                    {{-- <h2 class="mb-4">Laravel 7|8 Yajra Datatables Example</h2> --}}
                    @if ( $students->count() > 0 )
                        <table class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>University Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $students as $student )
                                    <tr>
                                        <td>{{ $student->firstname }}</td>
                                        <td>{{ $student->lastname }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ $student->university() }}</td>
                                        <td>
                                            <form class="inline-block" action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-primary btn-sm" href="{{ route('students.edit',$student->id) }}">Edit</a>
                                                <input type="submit" class="btn btn-danger btn-sm" value="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $students->links() !!}
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
