    @extends('frontend.layouts.app')

    @section('content')

        <div class="container">
            <h1 class="text-center display-6 fw-bold mb-5">
                Tour Package Price Calculator
            </h1>
            <div class="form-card">
                <form action="{{ route('calculator.calculate') }}" method="POST">
                    @csrf
                   <div class="mb-4">
                    <label class="form-label">Destinations</label>
                    <select class="form-select @error('destination_id') is-invalid @enderror" id="destination" name="destination_id">
                        <option selected disabled>Select Destination</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                    <div class="mb-4">
                        <label class="form-label">Theme</label>
                        <select class="form-select" id="theme" name="theme_id" disabled>
                            <option>Select Theme</option>
                        </select>
                    </div>

                    <!-- Package -->
                    <div class="mb-4">
                        <label class="form-label">Package</label>
                        <select class="form-select" id="package" name="package_id" disabled>
                            <option>Select Package</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Hotel Category</label>
                        <select class="form-select" name="hotel_category_id">
                            <option selected disabled>Select Hotel Category</option>
                            @foreach ($hotelCategories as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Travel Date</label>
                        <div class="note-text">Rates & availability depend on this</div>
                        <div class="date-group mt-2">
                            <input type="date" name="travel_date" class="form-control" placeholder="dd-mm-yyyy" />
                        </div>

                    </div>

                    <!-- Rooms & Occupancy -->
                    <div class="mb-5">
                        <h5 class="fw-semibold mb-4">Rooms & Occupancy</h5>
                        <div id="rooms-container">
                            <div class="room-box">
                                <button type="button" class="remove-btn" onclick="removeRoom(this)" style="display: none">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="room-title">Room 1</div>
                                <div class="row g-3">
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Adults</label>
                                        <select class="form-select" name="rooms[0][adults]">
                                            <option>1</option>
                                            <option selected>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Child (with bed)</label>
                                        <select class="form-select" name="rooms[0][child_with_bed]">
                                            <option selected>0</option>
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Child (no bed)</label>
                                        <select class="form-select" name="rooms[0][child_no_bed]">
                                            <option selected>0</option>
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small">Infant</label>
                                        <select class="form-select" name="rooms[0][infant]">
                                            <option selected>0</option>
                                            <option>1</option>
                                            <option>2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center my-4">
                            <button type="button" class="btn add-room-btn" onclick="addRoom()">
                                + Add Room
                            </button>
                        </div>
                    </div>

                    <!-- Vehicle -->
                    <div class="mb-4">
                        <label class="form-label">Vehicle</label>
                        <select class="form-select" id="vehicle" name="vehicle_id">
                            <option selected disabled>Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" data-capacity="{{ $vehicle->capacity }}">
                                    {{ $vehicle->name }} ({{ $vehicle->capacity }} pax)
                                </option>
                            @endforeach
                        </select>


                    </div>

                    <!-- Markup & GST -->
                    <div class="row align-items-end mb-5">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label class="form-label">Add Markup (percentage)</label>
                            <div class="input-group markup-group">
                                <input type="number" class="form-control" value="0" min="0" name="markup" />
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="add_gst" name="add_gst" />
                                <label class="form-check-label fw-medium" for="add_gst">Add GST (5%)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Calculate -->
                    <div class="text-center">
                        <button type="submit" class="btn calculate-btn">
                            Calculate Price
                        </button>
                    </div>
                </form>

                @if (session('totalPrice'))
                    <div class="card mt-5 shadow-sm">
                        <div class="card-body">

                            <h5 class="fw-bold mb-3">Per Person Prices</h5>

                            <div class="d-flex justify-content-between">
                                <span>Adult (Double Sharing)</span>
                                <span>
                                    ₹ {{ number_format(session('quotation_' . session('pdfToken'))['perPersonPrice']) }}
                                    × {{ session('quotation_' . session('pdfToken'))['adultCount'] }}
                                </span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Package Price</span>
                                <span>₹ {{ number_format(session('totalPrice')) }}</span>
                            </div>

                            <div class="text-muted mt-2 small">
                                @if (session('quotation_' . session('pdfToken'))['gstApplied'])
                                    GST included <br>
                                @endif

                                @if (session('quotation_' . session('pdfToken'))['markupPercent'] > 0)
                                    Agent markup ({{ session('quotation_' . session('pdfToken'))['markupPercent'] }}%)
                                    included
                                @endif
                            </div>

                            <a href="{{ route('calculator.pdf', session('pdfToken')) }}" target="_blank"
                                class="btn btn-dark mt-3">
                                View PDF
                            </a>

                        </div>
                    </div>
                @endif

            </div>
        </div>
        <script>
            document.getElementById('destination').addEventListener('change', function() {
                fetch(`/ajax/themes/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        const theme = document.getElementById('theme');
                        theme.innerHTML = '<option>Select Theme</option>';
                        theme.disabled = false;

                        data.forEach(item => {
                            theme.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                        });

                        resetSelect('package');
                    });
            });

            document.getElementById('theme').addEventListener('change', function() {
                fetch(`/ajax/packages/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        const pkg = document.getElementById('package');
                        pkg.innerHTML = '<option>Select Package</option>';
                        pkg.disabled = false;

                        data.forEach(item => {
                            pkg.innerHTML += `
                    <option value="${item.id}">
                        ${item.name} (${item.days}D/${item.nights}N)
                    </option>`;
                        });
                    });
            });

            function resetSelect(id) {
                const el = document.getElementById(id);
                el.innerHTML = '<option>Select</option>';
                el.disabled = true;
            }
        </script>
        <script>
            document.addEventListener('change', function(e) {
                if (e.target.name && e.target.name.startsWith('rooms')) {
                    filterVehiclesByPax();
                }
            });
        </script>

        <script>
            function filterVehiclesByPax() {
                const pax = calculateTotalPax();
                const vehicleSelect = document.getElementById('vehicle');

                let minCapacity = 4;

                if (pax <= 4) {
                    minCapacity = 4;
                } else if (pax <= 7) {
                    minCapacity = 6;
                } else {
                    minCapacity = 12;
                }

                let hasOption = false;

                Array.from(vehicleSelect.options).forEach(option => {
                    const capacity = parseInt(option.dataset.capacity || 0);

                    // Skip placeholder
                    if (!capacity) return;

                    if (capacity >= minCapacity) {
                        option.hidden = false;
                        hasOption = true;
                    } else {
                        option.hidden = true;
                    }
                });

                vehicleSelect.disabled = !hasOption;

                // Reset selection if current is invalid
                if (
                    vehicleSelect.selectedOptions.length &&
                    vehicleSelect.selectedOptions[0].hidden
                ) {
                    vehicleSelect.value = '';
                }
            }

            function calculateTotalPax() {
                let total = 0;

                document.querySelectorAll('[name^="rooms"]').forEach(el => {
                    if (
                        el.name.includes('[adults]') ||
                        el.name.includes('[child_with_bed]')
                    ) {
                        total += parseInt(el.value || 0);
                    }
                });

                return total;
            }
        </script>
    @endsection
