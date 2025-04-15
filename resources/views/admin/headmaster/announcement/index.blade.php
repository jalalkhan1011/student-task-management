@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Announcement') }}</h1>
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
                                {{ __('Announcement List') }}
                            </div>
                            <div class="col-md-6 text-right">
                                @if (Auth::user()->role == 'Headmaster')
                                    <a href="{{ route('announcements.create') }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-plus"></i> {{ __('Add Announcement') }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">{{ __('#Sl') }}</th>
                                    <th scope="col">{{ __('Title') }}</th>
                                    <th scope="col">{{ __('Description') }}</th>
                                    <th scope="col">{{ __('Schedule') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach ($announcements as $announcement)
                                    <tr>
                                        <td scope="row">{{ ++$i }}</td>
                                        <td>{{ $announcement->title ?: '' }}</td>
                                        <td>{{ $announcement->description ?: '' }}</td>
                                        <td>{{ date('d-M-Y H:i', strtotime($announcement->scheduled_at ?: '')) }}</td>
                                        <td>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('announcements.edit', $announcement->id) }}"
                                                        class="btn btn-warning btn-sm"><i
                                                            class="fa fa-edit">{{ __('EDIT') }}</i></a>
                                                </li>
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
