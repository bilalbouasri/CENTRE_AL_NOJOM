@extends('layouts.app')

@section('title', __('Monthly Revenue Comparison'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Monthly Revenue Comparison') }} - Last 6 Months</h1>
                <div>
                    <a href="{{ route('monthly-revenues.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                    <a href="{{ route('monthly-revenues.year-to-date') }}" class="btn btn-info">
                        <i class="fas fa-chart-line"></i> {{ __('Year to Date') }}
                    </a>
                    <a href="{{ route('monthly-revenues.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> {{ __('Export CSV') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparison Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> {{ __('Revenue Trend - Last 6 Months') }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="comparisonChart" width="400" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Comparison Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Detailed Monthly Comparison') }}</h5>
                </div>
                <div class="card-body">
                    @if(count($comparisonData) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Month') }}</th>
                                        <th>{{ __('Total Revenue') }}</th>
                                        <th>{{ __('Payment Count') }}</th>
                                        <th>{{ __('Average Payment') }}</th>
                                        <th>{{ __('Growth Amount') }}</th>
                                        <th>{{ __('Growth %') }}</th>
                                        <th>{{ __('Trend') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comparisonData as $data)
                                        @php
                                            $revenue = $data['revenue'];
                                            $growth = $data['growth'];
                                            $isPositiveGrowth = $growth && $growth['amount'] >= 0;
                                            $isNegativeGrowth = $growth && $growth['amount'] < 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $revenue->month_year }}</strong>
                                            </td>
                                            <td class="font-weight-bold text-success">
                                                {{ $revenue->formatted_revenue }}
                                            </td>
                                            <td>{{ $revenue->payment_count }}</td>
                                            <td>{{ $revenue->formatted_average_payment }}</td>
                                            <td>
                                                @if($growth)
                                                    <span class="text-{{ $isPositiveGrowth ? 'success' : 'danger' }}">
                                                        <i class="fas fa-arrow-{{ $isPositiveGrowth ? 'up' : 'down' }}"></i>
                                                        MAD {{ number_format(abs($growth['amount']), 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($growth)
                                                    <span class="text-{{ $isPositiveGrowth ? 'success' : 'danger' }}">
                                                        {{ $isPositiveGrowth ? '+' : '' }}{{ number_format($growth['percentage'], 2) }}%
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($growth)
                                                    @if($growth['percentage'] > 10)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-rocket"></i> {{ __('Strong Growth') }}
                                                        </span>
                                                    @elseif($growth['percentage'] > 0)
                                                        <span class="badge badge-info">
                                                            <i class="fas fa-arrow-up"></i> {{ __('Growing') }}
                                                        </span>
                                                    @elseif($growth['percentage'] < -10)
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-arrow-down"></i> {{ __('Declining') }}
                                                        </span>
                                                    @elseif($growth['percentage'] < 0)
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-arrow-down"></i> {{ __('Slight Decline') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">
                                                            <i class="fas fa-minus"></i> {{ __('Stable') }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-minus"></i> {{ __('No Data') }}
                                                    </span>
                                                @endif
                                            </td>
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
                            </table>
                        </div>

                        <!-- Summary Statistics -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Performance Summary') }}</h6>
                                        @php
                                            $totalGrowth = 0;
                                            $growthCount = 0;
                                            $positiveGrowthMonths = 0;
                                            $negativeGrowthMonths = 0;
                                            
                                            foreach($comparisonData as $data) {
                                                if($data['growth']) {
                                                    $totalGrowth += $data['growth']['percentage'];
                                                    $growthCount++;
                                                    if($data['growth']['percentage'] > 0) {
                                                        $positiveGrowthMonths++;
                                                    } else {
                                                        $negativeGrowthMonths++;
                                                    }
                                                }
                                            }
                                            
                                            $averageGrowth = $growthCount > 0 ? $totalGrowth / $growthCount : 0;
                                        @endphp
                                        <p><strong>{{ __('Average Growth') }}:</strong> 
                                            <span class="text-{{ $averageGrowth >= 0 ? 'success' : 'danger' }}">
                                                {{ number_format($averageGrowth, 2) }}%
                                            </span>
                                        </p>
                                        <p><strong>{{ __('Positive Growth Months') }}:</strong> 
                                            <span class="text-success">{{ $positiveGrowthMonths }}</span>
                                        </p>
                                        <p><strong>{{ __('Negative Growth Months') }}:</strong> 
                                            <span class="text-danger">{{ $negativeGrowthMonths }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('Revenue Statistics') }}</h6>
                                        @php
                                            $revenues = collect($comparisonData)->pluck('revenue');
                                            $highestRevenue = $revenues->max('total_revenue');
                                            $lowestRevenue = $revenues->min('total_revenue');
                                            $totalRevenue = $revenues->sum('total_revenue');
                                        @endphp
                                        <p><strong>{{ __('Highest Revenue') }}:</strong> 
                                            <span class="text-success">MAD {{ number_format($highestRevenue, 2) }}</span>
                                        </p>
                                        <p><strong>{{ __('Lowest Revenue') }}:</strong> 
                                            <span class="text-danger">MAD {{ number_format($lowestRevenue, 2) }}</span>
                                        </p>
                                        <p><strong>{{ __('Total 6-Month Revenue') }}:</strong> 
                                            <span class="text-primary">MAD {{ number_format($totalRevenue, 2) }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> 
                            {{ __('No comparison data available.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@if(count($comparisonData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('comparisonChart').getContext('2d');
        const months = @json(collect($comparisonData)->pluck('revenue.month_year')->reverse());
        const revenues = @json(collect($comparisonData)->pluck('revenue.total_revenue')->reverse());
        const growthPercentages = @json(collect($comparisonData)->map(function($data) {
            return $data['growth'] ? $data['growth']['percentage'] : 0;
        })->reverse());

        // Create gradient for the chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(54, 162, 235, 0.8)');
        gradient.addColorStop(1, 'rgba(54, 162, 235, 0.2)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Monthly Revenue (MAD)',
                        data: revenues,
                        backgroundColor: gradient,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Growth %',
                        data: growthPercentages,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Revenue Trend with Growth Percentage'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Revenue (MAD)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'MAD ' + value.toLocaleString();
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Growth %'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
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