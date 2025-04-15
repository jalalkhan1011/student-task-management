@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Feedback') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Task Feedback') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('submissions.feedback', $task) }}" method="POST" >
                            @csrf
                            <div class="form-group">
                                <label for="feedback">{{ __('Feedback') }}<span class="text-danger">
                                        *</span></label>
                                <textarea class="form-control" id="feedback" name="feedback" value="{{ old('feedback') }}" aria-describedby="nameHelp"
                                    placeholder="Write...." required>{{ old('feedback') }}</textarea>

                                <div class="clearfix"></div>
                                @if ($errors->has('feedback'))
                                    <span class="form-text">
                                        <strong class="text-danger form-control-sm">{{ $errors->first('feedback') }}</strong>
                                    </span>
                                @endif
                            </div> 
                            <button type="submit" class="btn btn-primary">{{ __('Feedback') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
