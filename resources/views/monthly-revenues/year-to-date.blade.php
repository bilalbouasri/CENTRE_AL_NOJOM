@extends('layouts.app')

@section('title', __('Year to Date Revenue'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Year to Date Revenue') }} - {{ date('Y') }}</h1>
                <div>
                    <a href="{{ route('monthly-revenues.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                    <a href="{{ route('monthly-revenues.comparison') }}" class="btn btn-warning">
                        <i class="fas fa-chart-bar"></i> {{ __('Monthly Comparison') }}
                    </a>
                    <a href="{{ route('monthly-revenues.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> {{ __('Export CSV') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Year to Date Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> {{ __('Year to Date Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Total Revenue') }}</h6>
                                    <h3>MAD {{ number_format($yearToDate['total_revenue'], 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Total Payments') }}</h6>
                                    <h3>{{ $yearToDate['total_payments'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Average Monthly Revenue') }}</h6>
                                    <h3>MAD {{ number_format($yearToDate['average_monthly_revenue'], 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('Months Tracked') }}</h6>
                                    <h3>{{ $yearToDate['revenues']->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Monthly Breakdown') }}</h5>
                </div>
                <div class="card-body">
                    @if($yearToDate['revenues']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Month') }}</th>
                                        <th>{{ __('Total Revenue') }}</th>
                                        <th>{{ __('Payment Count') }}</th>
                                        <th>{{ __('Average Payment') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($yearToDate['revenues'] as $revenue)
                                        <tr>
                                            <td>
                                                <strong>{{ $revenue->month_name }}</strong>
                                            </td>
                                            <td class="font-weight-bold text-success">
                                                {{ $revenue->formatted_revenue }}
                                            </td>
                                            <td>{{ $revenue->payment_count }}</td>
                                            <td>{{ $revenue->formatted_average_payment }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('monthly-revenues.show', $revenue) }}" 
                                                       class="btn btn-info" title="{{ __('View Details') }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('payments.index') }}?month={{ $revenue->month }}&year={{ $revenue->year }}" 
                                                       class="btn btn-primary" title="{{ __('View Payments') }}">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <td><strong>{{ __('Total') }}</strong></td>
                                        <td><strong>MAD {{ number_format($yearToDate['total_revenue'], 2) }}</strong></td>
                                        <td><strong>{{ $yearToDate['total_payments'] }}</strong></td>
                                        <td><strong>MAD {{ number_format($yearToDate['total_revenue'] / max($yearToDate['total_payments'], 1), 2) }}</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> 
                            {{ __('No revenue data available for the current year.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> {{ __('Revenue Distribution') }}</h5>
                </div>
                <div class="card-body">
                    @if($yearToDate['revenues']->count() > 0)
                        <canvas id="revenueChart" width="400" height="300"></canvas>
                        <div class="mt-3">
                            <h6>{{ __('Top 3 Months') }}</h6>
                            <ul class="list-group">
                                @foreach($yearToDate['revenues']->sortByDesc('total_revenue')->take(3) as $topRevenue)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $topRevenue->month_name }}
                                        <span class="badge badge-success badge-pill">
                                            MAD {{ number_format($topRevenue->total_revenue, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle"></i> 
                            {{ __('No data available for chart.') }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs"></i> {{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('monthly-revenues.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> {{ __('Add Monthly Revenue') }}
                        </a>
                        <a href="{{ route('monthly-revenues.export') }}" class="btn btn-outline-success">
                            <i class="fas fa-download"></i> {{ __('Export Full Data') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-info">
                            <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if($yearToDate['revenues']->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const months = @json($yearToDate['revenues']->pluck('month_name'));
        const revenues = @json($yearToDate['revenues']->pluck('total_revenue'));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Monthly Revenue (MAD)',
                    data: revenues,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Monthly Revenue Distribution'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'MAD ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endif
@endpush
@endsection