@extends('layouts.app')

@section('title', __('Monthly Revenues'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Monthly Revenues') }}</h1>
                <div>
                    <a href="{{ route('monthly-revenues.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Add Monthly Revenue') }}
                    </a>
                    <a href="{{ route('monthly-revenues.year-to-date') }}" class="btn btn-info">
                        <i class="fas fa-chart-line"></i> {{ __('Year to Date') }}
                    </a>
                    <a href="{{ route('monthly-revenues.comparison') }}" class="btn btn-warning">
                        <i class="fas fa-chart-bar"></i> {{ __('Comparison') }}
                    </a>
                    <a href="{{ route('monthly-revenues.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> {{ __('Export CSV') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Month Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt"></i> {{ __('Current Month Summary') }} - {{ $currentMonthRevenue->month_year }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Total Revenue') }}</h6>
                                    <h4 class="text-primary">{{ $currentMonthRevenue->formatted_revenue }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Payment Count') }}</h6>
                                    <h4 class="text-info">{{ $currentMonthRevenue->payment_count }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Average Payment') }}</h6>
                                    <h4 class="text-success">{{ $currentMonthRevenue->formatted_average_payment }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Year to Date') }}</h6>
                                    <h4 class="text-warning">MAD {{ number_format($yearToDate['total_revenue'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenues Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Monthly Revenue History') }}</h5>
                </div>
                <div class="card-body">
                    @if($revenues->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Month') }}</th>
                                        <th>{{ __('Year') }}</th>
                                        <th>{{ __('Total Revenue') }}</th>
                                        <th>{{ __('Payment Count') }}</th>
                                        <th>{{ __('Average Payment') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($revenues as $revenue)
                                        <tr>
                                            <td>{{ $revenue->month_name }}</td>
                                            <td>{{ $revenue->year }}</td>
                                            <td class="font-weight-bold text-success">{{ $revenue->formatted_revenue }}</td>
                                            <td>{{ $revenue->payment_count }}</td>
                                            <td>{{ $revenue->formatted_average_payment }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('monthly-revenues.show', $revenue) }}" 
                                                       class="btn btn-info" title="{{ __('View Details') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('monthly-revenues.edit', $revenue) }}" 
                                                       class="btn btn-warning" title="{{ __('Edit') }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('monthly-revenues.recalculate', $revenue) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary" 
                                                                title="{{ __('Recalculate') }}"
                                                                onclick="return confirm('{{ __('Are you sure you want to recalculate this monthly revenue?') }}')">
                                                            <i class="fas fa-calculator"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('monthly-revenues.destroy', $revenue) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" 
                                                                title="{{ __('Delete') }}"
                                                                onclick="return confirm('{{ __('Are you sure you want to delete this monthly revenue record?') }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $revenues->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> 
                            {{ __('No monthly revenue records found.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection