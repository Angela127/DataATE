@extends('layouts.admin')

@section('content')
    <style>
        .fleet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .fleet-title {
            font-size: 24px;
            font-weight: 700;
            color: #1E293B;
        }

        .fleet-toolbar {
            display: flex;
            gap: 12px;
        }

        .fleet-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #FFFFFF;
            border-radius: 999px;
            border: 1px solid #E2E8F0;
            padding: 8px 14px;
            min-width: 280px;
        }

        .fleet-search input {
            border: none;
            outline: none;
            font-size: 14px;
            width: 100%;
            background: transparent;
            color: #1E293B;
        }

        .fleet-search svg {
            width: 16px;
            height: 16px;
            color: #64748B;
        }

        .btn-add-car {
            border: none;
            outline: none;
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            background: #FF7F50;
            color: #FFFFFF;
            cursor: pointer;
            transition: transform 0.1s ease, box-shadow 0.1s ease, background 0.1s ease;
        }

        .btn-add-car:hover {
            background: #ff6a32;
        }

        .fleet-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }

        .fleet-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .fleet-table thead tr {
            background: rgba(255, 247, 237, 2);
        }

        .fleet-table th,
        .fleet-table td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
            white-space: nowrap;
        }

        .fleet-table th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #000000ff;
        }

        .fleet-table th.status-col,
        .fleet-table td.status-col {
            text-align: center; /* Status 居中 */
        }

        .fleet-table th.actions-col,
        .fleet-table td.actions-col {
            text-align: center; /* Actions 标题和内容都居中 */
        }

        .fleet-table tbody tr:hover {
            background: rgba(255, 247, 237, 0.5);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 80px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-available {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-unavailable {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .btn-table {
            border: none;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.1s ease, transform 0.1s ease;
        }

        .btn-table-edit {
            background: #0EA5E9;
            color: white;
        }

        .btn-table-edit:hover {
            background: #0284C7;
            transform: translateY(-0.5px);
        }

        .btn-table-delete {
            background: #F97373;
            color: white;
        }

        .btn-table-delete:hover {
            background: #EF4444;
            transform: translateY(-0.5px);
        }

        .actions-wrapper {
            display: inline-flex;   /* 让 Edit / Delete 贴在一起 */
            align-items: center;
            gap: 8px;              /* 控制两个按钮之间的距离 */
        }

        .empty-state {
            text-align: center;
            color: #64748B;
            padding: 24px 0;
            font-size: 14px;
        }

        @media (max-width: 1024px) {
            .fleet-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="fleet-header">
        <div class="fleet-title">Fleet Management</div>

        <div class="fleet-toolbar">
            <form method="GET" action="{{ route('admin.cars.index') }}" class="fleet-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="6"></circle>
                    <line x1="16" y1="16" x2="21" y2="21"></line>
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search by plate number or model"
                >
            </form>

            <a href="{{ route('admin.cars.create') }}">
                <button type="button" class="btn-add-car">Add new car</button>
            </a>
        </div>
    </div>

    @if (session('success'))
        <div style="margin-bottom: 16px; padding: 10px 14px; border-radius: 10px; background:#DCFCE7; color:#166534; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="fleet-card">
        <table class="fleet-table">
            <thead>
                <tr>
                    <th>Plate No.</th>
                    <th>Model</th>
                    <th>Price / Hour</th>
                    <th>Fuel Level</th>
                    <th>Mileage</th>
                    <th class="status-col">Status</th>
                    <th class="actions-col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars as $car)
                    <tr>
                        <td>{{ $car->plate_no }}</td>
                        <td>{{ $car->model }}</td>
                        <td>RM {{ number_format($car->price_hour, 2) }}</td>
                        <td>{{ $car->fuel_level }}%</td>
                        <td>{{ number_format($car->car_mileage) }} km</td>
                        <td class="status-col">
                            @if($car->availability_status)
                                <span class="badge-status badge-available">Available</span>
                            @else
                                <span class="badge-status badge-unavailable">Not Avail.</span>
                            @endif
                        </td>
<<<<<<< Updated upstream
                        <td class="actions-col">
                            <div class="actions-wrapper">
                                <a href="{{ route('admin.cars.edit', $car->plate_no) }}">
                                    <button type="button" class="btn-table btn-table-edit">Edit</button>
                                </a>

                                <form action="{{ route('admin.cars.destroy', $car->plate_no) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this car?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-table btn-table-delete">
                                        Delete
                                    </button>
                                </form>
                            </div>
=======
                        <td style="text-align:right;">
                            <a href="{{ route('admin.cars.edit', $car->plate_no) }}">
                                <button type="button" class="btn-table btn-table-edit" style="text-decoration: none;">Edit</button>
                            </a>

                            <form action="{{ route('admin.cars.destroy', $car->plate_no) }}"
                                  method="POST"
                                  style="display:inline-block"
                                  onsubmit="return confirm('Delete this car?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-table btn-table-delete" style="text-decoration: none;">
                                    Delete
                                </button>
                            </form>
>>>>>>> Stashed changes
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            No cars in the fleet yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection