@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Student') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Student List') }}
                            </div>
                            <div class="col-md-6 text-right">
                                @if (Auth::user()->role == 'Teacher')
                                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-plus"></i> {{ __('Add Student') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">{{ __('#Sl') }}</th>
                                    <th scope="col">{{ __('Student') }}</th>
                                    <th scope="col">{{ __('Email') }}</th>
                                    <th scope="col">{{ __('Delete Status') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach ($students as $student)
                                    <tr>
                                        <td scope="row">{{ ++$i }}</td>
                                        <td>{{ $student->name ?: '' }}</td>
                                        <td>{{ $student->email ?: '' }}</td>
                                        <td>
                                            @foreach ($deletions as $deletion)
                                                @if ($deletion->student_id == $student->id)
                                                    @if ($deletion->status == 'pending')
                                                        <span class="badge badge-warning">{{ __('Pending') }}</span>
                                                    @elseif ($deletion->status == 'approved')
                                                        <span class="badge badge-danger">{{ __('Approved') }}</span>
                                                    @elseif ($deletion->status == 'rejected')
                                                        <span class="badge badge-secondary">{{ __('Rejected') }}</span>
                                                    @else
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <ul class="list-inline">
                                                @if (Auth::user()->role == 'Teacher' || Auth::user()->role == 'Headmaster')
                                                    @if ($student->status != 'approved')
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('students.edit', $student->id) }}"
                                                                class="btn btn-warning btn-sm"><i
                                                                    class="fa fa-edit">{{ __('EDIT') }}</i></a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->role == 'Teacher')
                                                    @if ($student->status == null)
                                                        <li class="list-inline-item">
                                                            <form
                                                                action="{{ route('student.delete.request', $student->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash">
                                                                        {{ __('Delete Request') }}</i></button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if (Auth::user()->role == 'Headmaster')
                                                    @if ($student->status == 'pending')
                                                        <li class="list-inline-item">
                                                            <form action="{{ route('student.delete', $student->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash">
                                                                        {{ __('Delete') }}</i></button>
                                                            </form>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <form
                                                                action="{{ route('student.delete.reject', $student->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-secondary btn-sm"><i
                                                                        class="fa fa-trash">
                                                                        {{ __('Delete Reject') }}</i></button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
