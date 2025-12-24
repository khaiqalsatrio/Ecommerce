@extends('admin.layout.admin')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>User</th>
                        <th style="width:180px;">Total</th>
                        <th style="width:140px;">Payment Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $loop->iteration }}</td>

                        {{-- USER --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $order->user->name ?? '-' }}
                            </div>
                            <small class="text-muted">
                                Order ID: #{{ $order->id }}
                            </small>
                        </td>

                        {{-- TOTAL --}}
                        <td>
                            <span class="fw-semibold">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge
                                {{ $order->payment_status === 'paid'
                                    ? 'bg-success-subtle text-success'
                                    : 'bg-warning-subtle text-warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="bi bi-receipt fs-4 d-block mb-2"></i>
                            No orders found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection