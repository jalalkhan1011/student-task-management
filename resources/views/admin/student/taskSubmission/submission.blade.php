@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Submission') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Task Submission') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="notes">{{ __('Notes') }}<span class="text-danger">
                                        *</span></label>
                                <textarea class="form-control" id="notes" name="notes" value="{{ old('notes') }}" aria-describedby="nameHelp"
                                    placeholder="Write...." required>{{ old('notes') }}</textarea>

                                <div class="clearfix"></div>
                                @if ($errors->has('notes'))
                                    <span class="form-text">
                                        <strong class="text-danger form-control-sm">{{ $errors->first('notes') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="file">{{ __('File') }}<span class="text-danger"> </span></label>
                                <input type="file" class="form-control" id="file" name="file"
                                    value="{{ old('file') }}" aria-describedby="nameHelp" placeholder="Enter name">

                                <div class="clearfix"></div>
                                @if ($errors->has('file'))
                                    <span class="form-text">
                                        <strong class="text-danger form-control-sm">{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
