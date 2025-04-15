@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Task') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Task Edit') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title', $task->title) }}" aria-describedby="nameHelp"
                                            placeholder="Enter title" required>

                                        <div class="clearfix"></div>
                                        @if ($errors->has('title'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_id">{{ __('Student') }}<span class="text-danger">
                                                *</span></label>
                                        <select class="form-control" id="student_id" name="student_id" required>
                                            <option value="" disabled selected>{{ __('Select Student') }}</option>
                                            @foreach ($students as $key => $student)
                                                <option value="{{ $key }}"
                                                    {{ $key == $selectedStudent ? 'selected' : '' }}>{{ $student }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="clearfix"></div>
                                        @if ($errors->has('student_id'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('student_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}<span class="text-danger">
                                                *</span></label>
                                        <textarea id="description" class="form-control" name="description" rows="5" required>{{ old('description', $task->description) }}</textarea>

                                        <div class="clearfix"></div>
                                        @if ($errors->has('description'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
