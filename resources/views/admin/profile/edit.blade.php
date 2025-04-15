@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Profile') }}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Profile Edit') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.edit', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ __('Name') }}<span class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" aria-describedby="nameHelp"
                                    placeholder="Enter name" required>

                                <div class="clearfix"></div>
                                @if ($errors->has('name'))
                                    <span class="form-text">
                                        <strong class="text-danger form-control-sm">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}<span class="text-danger"> </span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}" aria-describedby="nameHelp"
                                    placeholder="Enter name">

                                <div class="clearfix"></div>
                                @if ($errors->has('phone'))
                                    <span class="form-text">
                                        <strong class="text-danger form-control-sm">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
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
