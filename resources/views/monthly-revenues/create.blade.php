@extends('layouts.app')

@section('title', __('Add Monthly Revenue'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Add Monthly Revenue') }}</h1>
                <a href="{{ route('monthly-revenues.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Create Monthly Revenue Record') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('monthly-revenues.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="month">{{ __('Month') }} *</label>
                                    <select name="month" id="month" class="form-control @error('month') is-invalid @enderror" required>
                                        <option value="">{{ __('Select Month') }}</option>
                                        @foreach([
                                            1 => 'January',
                                            2 => 'February',
                                            3 => 'March',
                                            4 => 'April',
                                            5 => 'May',
                                            6 => 'June',
                                            7 => 'July',
                                            8 => 'August',
                                            9 => 'September',
                                            10 => 'October',
                                            11 => 'November',
                                            12 => 'December'
                                        ] as $monthNum => $monthName)
                                            <option value="{{ $monthNum }}" {{ old('month') == $monthNum ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year">{{ __('Year') }} *</label>
                                    <input type="number" 
                                           name="year" 
                                           id="year" 
                                           class="form-control @error('year') is-invalid @enderror" 
                                           value="{{ old('year', date('Y')) }}" 
                                           min="2020" 
                                           max="2030" 
                                           required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">{{ __('Notes') }}</label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3" 
                                      placeholder="{{ __('Optional notes about this monthly revenue record...') }}">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            {{ __('This will automatically calculate the monthly revenue based on all payments for the selected month and year.') }}
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calculator"></i> {{ __('Calculate Monthly Revenue') }}
                            </button>
                            <a href="{{ route('monthly-revenues.index') }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection