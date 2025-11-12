@extends('layouts.app')

@section('title', __('Edit Monthly Revenue'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Edit Monthly Revenue') }} - {{ $monthlyRevenue->month_year }}</h1>
                <a href="{{ route('monthly-revenues.show', $monthlyRevenue) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Details') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Edit Monthly Revenue Record') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('monthly-revenues.update', $monthlyRevenue) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Display Read-only Month and Year -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Month') }}</label>
                                    <input type="text" class="form-control" value="{{ $monthlyRevenue->month_name }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Year') }}</label>
                                    <input type="text" class="form-control" value="{{ $monthlyRevenue->year }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Display Revenue Summary (Read-only) -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Total Revenue') }}</label>
                                    <input type="text" class="form-control bg-light" value="{{ $monthlyRevenue->formatted_revenue }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Payment Count') }}</label>
                                    <input type="text" class="form-control bg-light" value="{{ $monthlyRevenue->payment_count }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{ __('Average Payment') }}</label>
                                    <input type="text" class="form-control bg-light" value="{{ $monthlyRevenue->formatted_average_payment }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Editable Notes -->
                        <div class="form-group">
                            <label for="notes">{{ __('Notes') }}</label>
                            <textarea name="notes" 
                                      id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="{{ __('Optional notes about this monthly revenue record...') }}">{{ old('notes', $monthlyRevenue->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ __('Note: Monthly revenue data is automatically calculated from payments. To update the revenue figures, use the "Recalculate" button on the details page.') }}
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Update Notes') }}
                            </button>
                            <a href="{{ route('monthly-revenues.show', $monthlyRevenue) }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                            <a href="{{ route('monthly-revenues.recalculate', $monthlyRevenue) }}" 
                               class="btn btn-info float-right"
                               onclick="return confirm('{{ __('Are you sure you want to recalculate this monthly revenue?') }}')">
                                <i class="fas fa-calculator"></i> {{ __('Recalculate Revenue') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection