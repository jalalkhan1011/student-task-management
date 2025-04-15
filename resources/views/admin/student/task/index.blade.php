@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Task') }}</h1>
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
                                {{ __('Task List') }}
                            </div>
                            <div class="col-md-6 text-right">
                                @if (Auth::user()->role == 'Teacher')
                                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-plus"></i> {{ __('Add Task') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($tasks->isEmpty())
                            <p>Your tasks are pending for approval.</p>
                        @else
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">{{ __('#Sl') }}</th>
                                        <th scope="col">{{ __('Title') }}</th>
                                        <th scope="col">{{ __('Description') }}</th>
                                        <th scope="col">{{ __('Teacher') }}</th>
                                        <th scope="col">{{ __('Student') }}</th>
                                        <th scope="col">{{ __('Aprrove') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td scope="row">{{ ++$i }}</td>
                                            <td>{{ $task->title ?: '' }}</td>
                                            <td>{{ $task->description ?: '' }}</td>
                                            <td>{{ $task->teacher->name ?: '' }}</td>
                                            <td>{{ $task->student->name ?: '' }}</td>
                                            <td>
                                                @if ($task->approved_at != null)
                                                    {{ date('d-m-Y h:i', strtotime($task->approved_at ?: '')) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
