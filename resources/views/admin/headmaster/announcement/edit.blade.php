@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Announcement') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Announcement Edit') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('announcements.update', $announcement->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">{{ __('Title') }}<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title', $announcement->title) }}" aria-describedby="nameHelp"
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
                                        <label for="scheduled_at">{{ __('scheduled') }}<span class="text-danger">
                                                *</span></label>
                                        <input type="date" class="form-control" id="scheduled_at" name="scheduled_at"
                                            value="{{ old('scheduled_at', date('d-m-Y', strtotime($announcement->scheduled_at))) }}"
                                            aria-describedby="nameHelp" placeholder="Enter scheduled_at" required>

                                        <div class="clearfix"></div>
                                        @if ($errors->has('scheduled_at'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('scheduled_at') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">{{ __('Description') }}<span class="text-danger">
                                                *</span></label>
                                        <textarea id="description" class="form-control" name="description" value="{{ old('description') }}" rows="5"
                                            required>{{ old('description', $announcement->description) }}</textarea>

                                        <div class="clearfix"></div>
                                        @if ($errors->has('description'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">{{ __('Image') }}<span class="text-danger">
                                            </span></label>
                                        <img src="{{ asset($announcement->original_image_path) }}"
                                            alt="Photo">
                                        <input type="file" id="image" class="form-control" name="image"
                                            value="{{ old('image') }}">

                                        <div class="clearfix"></div>
                                        @if ($errors->has('image'))
                                            <span class="form-text">
                                                <strong
                                                    class="text-danger form-control-sm">{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
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
