@extends('admin.layout.admin')

@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <!-- Header Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="card-title mb-1 fw-bold">
                        <i class="bi bi-box-seam text-primary"></i> Daftar Pesanan
                    </h4>
                    <p class="text-muted mb-0">Kelola semua pesanan pelanggan Anda</p>
                </div>

                <!-- Filter Buttons -->
                <div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('admin.orders.index') }}"
                        class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="bi bi-list-ul"></i> Semua
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                        class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                        <i class="bi bi-clock"></i> Pending
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                        class="btn {{ request('status') == 'processing' ? 'btn-info' : 'btn-outline-info' }}">
                        <i class="bi bi-gear"></i> Processing
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}"
                        class="btn {{ request('status') == 'shipped' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="bi bi-truck"></i> Shipped
                    </a>
                    <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                        class="btn {{ request('status') == 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                        <i class="bi bi-check-circle"></i> Completed
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4" style="width: 60px;">#</th>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="px-4">
                                <span class="badge bg-secondary">
                                    {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $order->order_code }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; font-weight: 600;">
                                        {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $order->user->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if($order->items->count() > 0)
                                <div class="small">
                                    @foreach($order->items as $item)
                                    <div class="mb-1">
                                        <i class="bi bi-box text-muted"></i> {{ $item->product->name ?? 'Product not found' }}
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($order->items->count() > 0)
                                <div class="small">
                                    @foreach($order->items as $item)
                                    <div class="mb-1">
                                        <span class="badge bg-secondary">{{ $item->qty }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                @if($order->payment_status === 'paid')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Paid
                                </span>
                                @elseif($order->payment_status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock"></i> Pending
                                </span>
                                @elseif($order->payment_status === 'failed')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Failed
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                @endif
                            </td>

                            <td>
                                @if($order->status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-hourglass-split"></i> Pending
                                </span>
                                @elseif($order->status === 'processing')
                                <span class="badge bg-info">
                                    <i class="bi bi-arrow-repeat"></i> Processing
                                </span>
                                @elseif($order->status === 'shipped')
                                <span class="badge bg-primary">
                                    <i class="bi bi-box-seam"></i> Shipped
                                </span>
                                @elseif($order->status === 'completed')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-all"></i> Completed
                                </span>
                                @elseif($order->status === 'cancelled')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-octagon"></i> Cancelled
                                </span>
                                @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="text-muted small">
                                    <div><i class="bi bi-calendar3"></i> {{ $order->created_at->format('d M Y') }}</div>
                                    <div><i class="bi bi-clock"></i> {{ $order->created_at->format('H:i') }}</div>
                                </div>
                            </td>

                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Detail Button -->
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $order->id }}"
                                        title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Update Status Dropdown -->
                                    @if($order->payment_status === 'paid' && $order->status !== 'completed' && $order->status !== 'cancelled')
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-success dropdown-toggle"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            title="Update Status">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            @if($order->status === 'pending')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-gear text-info"></i> Set Processing
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

                                            @if($order->status === 'processing')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="shipped">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-truck text-primary"></i> Set Shipped
                                                    </button>
                                                </form>
                                            </li>
                                            @endif

                                            @if($order->status === 'shipped')
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-check-circle text-success"></i> Set Completed
                                                    </button>
                                                </form>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-1 d-block mb-3"></i>
                                    <h5>No Orders Found</h5>
                                    <p class="mb-0">There are no orders to display at the moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Orders (Outside the table loop) -->
@foreach($orders as $order)
<div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Order Details</h5>
                    <p class="mb-0 opacity-75 small">{{ $order->order_code }}</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Customer Information -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-person-circle text-primary"></i> Customer Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Name</small>
                                <strong>{{ $order->user->name }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Email</small>
                                <strong>{{ $order->user->email }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Phone</small>
                                <strong>{{ $order->user->phone ?? '-' }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Order Date</small>
                                <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-cart-check text-primary"></i> Order Items
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center" style="width: 80px;">Qty</th>
                                        <th class="text-end" style="width: 120px;">Price</th>
                                        <th class="text-end" style="width: 140px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Product not found' }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold text-success">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Status Information -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <small class="text-muted d-block mb-2">Payment Status</small>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }} fs-6">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <small class="text-muted d-block mb-2">Order Status</small>
                                <span class="badge bg-primary fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection