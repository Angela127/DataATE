@extends('layouts.admin')

@section('content')
    <style>
        .fleet-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .fleet-page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1E293B;
        }

        .fleet-page-subtitle {
            font-size: 13px;
            color: #64748B;
            margin-top: 4px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            border: 1px solid #E2E8F0;
            background: #FFFFFF;
            font-size: 13px;
            color: #475569;
            text-decoration: none;
        }

        .btn-back svg {
            width: 16px;
            height: 16px;
        }

        .fleet-form-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #E2E8F0;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            max-width: 960px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 24px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 4px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            padding: 10px 12px;
            font-size: 14px;
            color: #0F172A;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #FF7F50;
            box-shadow: 0 0 0 1px rgba(255, 127, 80, 0.25);
        }

        .form-group small {
            font-size: 12px;
            color: #94A3B8;
        }

        .form-error {
            font-size: 12px;
            color: #B91C1C;
            margin-top: 3px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1E293B;
            margin: 10px 0 4px;
        }

        .section-divider {
            height: 1px;
            background: #E2E8F0;
            margin-bottom: 16px;
        }

        .fleet-form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-outline {
            border-radius: 999px;
            border: 1px solid #CBD5F5;
            padding: 9px 18px;
            font-size: 14px;
            color: #475569;
            background: #FFFFFF;
            cursor: pointer;
        }

        .btn-primary {
            border-radius: 999px;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            background: #FF7F50;
            color: #FFFFFF;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(255, 127, 80, 0.35);
        }

        .btn-primary:hover {
            background: #ff6a32;
        }

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="fleet-page-header">
        <div>
            <div class="fleet-page-title">Add new car</div>
            <div class="fleet-page-subtitle">Create a new car in your fleet.</div>
        </div>

        <a href="{{ route('admin.cars.index') }}" class="btn-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back to list
        </a>
    </div>

    <div class="fleet-form-card">
        @if ($errors->any())
            <div style="margin-bottom: 14px; padding: 10px 12px; border-radius: 10px; background:#FEE2E2; color:#B91C1C; font-size: 13px;">
                Please fix the highlighted fields.
            </div>
        @endif

        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">Basic info</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="plate_no">Plate number *</label>
                    <input type="text" id="plate_no" name="plate_no" value="{{ old('plate_no') }}" required>
                    @error('plate_no')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="model">Model *</label>
                    <input type="text" id="model" name="model" value="{{ old('model') }}" required>
                    @error('model')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="production_year">Production year</label>
                    <input type="number" id="production_year" name="production_year" value="{{ old('production_year') }}">
                    @error('production_year')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="engine">Engine</label>
                    <input type="text" id="engine" name="engine" value="{{ old('engine') }}" placeholder="e.g. 1.3L Dual VVT-i">
                    @error('engine')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-title">Specs</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="engine_cc">Engine CC</label>
                    <input type="number" id="engine_cc" name="engine_cc" value="{{ old('engine_cc') }}">
                    @error('engine_cc')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fuel_type">Fuel type</label>
                    <input type="text" id="fuel_type" name="fuel_type" value="{{ old('fuel_type') }}" placeholder="Petrol / Diesel">
                    @error('fuel_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="transmission">Transmission</label>
                    <input type="text" id="transmission" name="transmission" value="{{ old('transmission') }}" placeholder="Automatic / Manual">
                    @error('transmission')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="drive_type">Drive type</label>
                    <input type="text" id="drive_type" name="drive_type" value="{{ old('drive_type') }}" placeholder="FWD / RWD / AWD">
                    @error('drive_type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="top_speed">Top speed (km/h)</label>
                    <input type="number" id="top_speed" name="top_speed" value="{{ old('top_speed') }}">
                    @error('top_speed')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_power">Max power (hp)</label>
                    <input type="number" id="max_power" name="max_power" value="{{ old('max_power') }}">
                    @error('max_power')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_torque">Max torque (Nm)</label>
                    <input type="number" id="max_torque" name="max_torque" value="{{ old('max_torque') }}">
                    @error('max_torque')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-title">Pricing & status</div>
            <div class="section-divider"></div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="price_hour">Price per hour (RM) *</label>
                    <input type="number" step="0.01" id="price_hour" name="price_hour" value="{{ old('price_hour') }}" required>
                    @error('price_hour')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fuel_level">Fuel level (%) *</label>
                    <input type="number" id="fuel_level" name="fuel_level" value="{{ old('fuel_level', 100) }}" required>
                    @error('fuel_level')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="car_mileage">Mileage (km) *</label>
                    <input type="number" id="car_mileage" name="car_mileage" value="{{ old('car_mileage') }}" required>
                    @error('car_mileage')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="availability_status">Availability *</label>
                    <select id="availability_status" name="availability_status" required>
                        <option value="1" {{ old('availability_status') == '1' ? 'selected' : '' }}>Available</option>
                        <option value="0" {{ old('availability_status') === '0' ? 'selected' : '' }}>Not available</option>
                    </select>
                    @error('availability_status')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="active_status">Active *</label>
                    <select id="active_status" name="active_status" required>
                        <option value="1" {{ old('active_status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('active_status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('active_status')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-title">Image</div>
            <div class="section-divider"></div>

            <div class="form-group" style="max-width: 360px;">
                <label for="image">Car image</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Optional. JPG/PNG, up to 2MB.</small>
                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="fleet-form-footer">
                <a href="{{ route('admin.cars.index') }}" class="btn-outline">Cancel</a>
                <button type="submit" class="btn-primary">Save car</button>
            </div>
        </form>
    </div>
@endsection