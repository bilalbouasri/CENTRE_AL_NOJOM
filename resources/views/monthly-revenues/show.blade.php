@extends('layouts.app')

@section('title', __('Monthly Revenue Details'))

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>{{ __('Monthly Revenue Details') }} - {{ $monthlyRevenue->month_year }}</h1>
                <div>
                    <a href="{{ route('monthly-revenues.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                    <a href="{{ route('monthly-revenues.edit', $monthlyRevenue) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                    </a>
                    <form action="{{ route('monthly-revenues.recalculate', $monthlyRevenue) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info" onclick="return confirm('{{ __('Are you sure you want to recalculate this monthly revenue?') }}')">
                            <i class="fas fa-calculator"></i> {{ __('Recalculate') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> {{ __('Revenue Summary') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">{{ __('Total Revenue') }}</h6>
                                    <h3 class="text-primary">{{ $monthlyRevenue->formatted_revenue }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">{{ __('Payment Count') }}</h6>
                                    <h3 class="text-info">{{ $monthlyRevenue->payment_count }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="card-title text-muted">{{ __('Average Payment') }}</h6>
                                    <h3 class="text-success">{{ $monthlyRevenue->formatted_average_payment }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Growth Comparison -->
                    @if($growthData)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-{{ $growthData['amount'] >= 0 ? 'success' : 'danger' }}">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-arrow-{{ $growthData['amount'] >= 0 ? 'up text-success' : 'down text-danger' }}"></i>
                                        {{ __('Growth from Previous Month') }}
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>{{ __('Previous Month') }}:</strong> 
                                            MAD {{ number_format($growthData['previous_revenue'], 2) }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>{{ __('Growth Amount') }}:</strong> 
                                            <span class="text-{{ $growthData['amount'] >= 0 ? 'success' : 'danger' }}">
                                                MAD {{ number_format(abs($growthData['amount']), 2) }}
                                                ({{ $growthData['amount'] >= 0 ? '+' : '-' }})
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>{{ __('Growth Percentage') }}:</strong> 
                                            <span class="text-{{ $growthData['percentage'] >= 0 ? 'success' : 'danger' }}">
                                                {{ number_format(abs($growthData['percentage']), 2) }}%
                                                ({{ $growthData['percentage'] >= 0 ? '+' : '-' }})
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Method Breakdown -->
                    @if($monthlyRevenue->revenue_by_method && count($monthlyRevenue->revenue_by_method) > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6><i class="fas fa-credit-card"></i> {{ __('Payment Method Breakdown') }}</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ __('Payment Method') }}</th>
                                            <th>{{ __('Count') }}</th>
                                            <th>{{ __('Amount') }}</th>
                                            <th>{{ __('Percentage') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($monthlyRevenue->revenue_by_method as $method => $data)
                                        <tr>
                                            <td>
                                                <span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $method)) }}</span>
                                            </td>
                                            <td>{{ $data['count'] }}</td>
                                            <td>MAD {{ number_format($data['amount'], 2) }}</td>
                                            <td>
                                                @php
                                                    $percentage = $monthlyRevenue->total_revenue > 0 
                                                        ? ($data['amount'] / $monthlyRevenue->total_revenue) * 100 
                                                        : 0;
                                                @endphp
                                                {{ number_format($percentage, 1) }}%
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($monthlyRevenue->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6><i class="fas fa-sticky-note"></i> {{ __('Notes') }}</h6>
                            <div class="card">
                                <div class="card-body">
                                    {{ $monthlyRevenue->notes }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-cogs"></i> {{ __('Quick Actions') }}</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('payments.index') }}?month={{ $monthlyRevenue->month }}&year={{ $monthlyRevenue->year }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> {{ __('View All Payments') }}
                        </a>
                        <a href="{{ route('monthly-revenues.export') }}?year={{ $monthlyRevenue->year }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-download"></i> {{ __('Export Year Data') }}
                        </a>
                        <form action="{{ route('monthly-revenues.destroy', $monthlyRevenue) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('{{ __('Are you sure you want to delete this monthly revenue record?') }}')">
                                <i class="fas fa-trash"></i> {{ __('Delete Record') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Record Information -->
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> {{ __('Record Information') }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('Created') }}:</strong> {{ $monthlyRevenue->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>{{ __('Last Updated') }}:</strong> {{ $monthlyRevenue->updated_at->format('Y-m-d H:i') }}</p>
                    @if($monthlyRevenue->notes)
                        <p><strong>{{ __('Notes') }}:</strong> {{ Str::limit($monthlyRevenue->notes, 100) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> 
                        {{ __('Recent Payments for') }} {{ $monthlyRevenue->month_year }}
                        <span class="badge badge-primary">{{ $payments->total() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Student') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Payment Method') }}</th>
                                        <th>{{ __('Payment Date') }}</th>
                                        <th>{{ __('Notes') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('students.show', $payment->student_id) }}">
                                                    {{ $payment->student->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="text-success font-weight-bold">
                                                MAD {{ number_format($payment->amount, 2) }}
                                            </td>
                                            <td>
                                            </td>
                                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                                            <td>{{ Str::limit($payment->notes, 50) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i> 
                            {{ __('No payments found for this month.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection