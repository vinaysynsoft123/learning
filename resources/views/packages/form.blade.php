@extends('layouts.app')

@section('content')
    <div class="container pb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ isset($package) ? 'Edit Package' : 'Add Package' }}</h4>
            </div>

            <div class="card-body">
                <form method="POST"
                    action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}">
                    @csrf
                    @isset($package)
                        @method('PUT')
                    @endisset

                    <div class="row">
                        {{-- Package Type --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package Type</label>
                            <select name="type" id="package_type" class="form-control" required>
                                <option value="">Select Package Type</option>
                                <option value="domestic" @selected(old('type', $package->type ?? '') == 'domestic')>Domestic</option>
                                <option value="international" @selected(old('type', $package->type ?? '') == 'international')>International</option>
                            </select>
                        </div>

                        {{-- Destination --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destination</label>
                            <select name="destination_id" id="destination_id" class="form-control" required>
                                <option value="">Select Destination</option>
                            </select>
                        </div>

                        {{-- Theme --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Theme</label>
                            <select name="theme_id" class="form-control" required>
                                <option value="">Select Theme</option>
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->id }}" @selected(old('theme_id', $package->theme_id ?? '') == $theme->id)>
                                        {{ $theme->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Package Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $package->name ?? '') }}" required>
                        </div>
                    </div>

                    {{-- Pricing --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Total Nights</label>
                            <input type="number" name="nights" class="form-control"
                                value="{{ old('nights', $package->nights ?? '') }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Base Price</label>
                            <input type="number" step="0.01" name="base_price" class="form-control"
                                value="{{ old('base_price', $package->base_price ?? '') }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Discount</label>
                            <input type="number" step="0.01" name="discount" class="form-control"
                                value="{{ old('discount', $package->discount ?? '') }}">
                        </div>
                    </div>

                    <hr>

                    {{-- Itinerary --}}
                    <h5>1. Night Management (Itinerary)</h5>
                    <div id="itinerary-container"></div>

                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-itinerary">
                        Add Destination Stop
                    </button>

                    <hr class="mt-4">

                    {{-- Hotel Mapping --}}
                    <h5>2. Hotel Assignment per Category</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Destination</th>
                                    @foreach ($categories as $cat)
                                        <th>{{ $cat->name }} Hotel</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="hotel-mapping-body"></tbody>
                        </table>
                    </div>

                    <hr>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $package->description ?? '') }}</textarea>
                    </div>
             
                    <div class="mb-3">
                        <label>Inclusions</label>
                        <textarea name="inclusions" class="form-control" rows="3">{{ old('inclusions', $package->inclusions ?? '') }}</textarea>
                    </div>

                
                    <div class="mb-3">
                        <label>Exclusions</label>
                        <textarea name="exclusions" class="form-control" rows="3">{{ old('exclusions', $package->exclusions ?? '') }}</textarea>
                    </div>
                    {{-- Status --}}
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @selected(old('status', $package->status ?? 1) == 1)>Active</option>
                            <option value="0" @selected(old('status', $package->status ?? 1) == 0)>Inactive</option>
                        </select>
                    </div>

                    <div class="mt-4 border-top pt-3">
                        <button class="btn btn-success px-5">Save Package</button>
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary px-4">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const domesticDestinations = @json($domesticDestinations);
            const internationalDestinations = @json($internationalDestinations);
            const categories = @json($categories);
            const hotels = @json($hotels);
            const existingMappings = @json(isset($package) ? $package->mappedHotels : []);

            let itineraryIndex = 0;

            const itineraryContainer = document.getElementById('itinerary-container');
            const hotelBody = document.getElementById('hotel-mapping-body');
            const packageType = document.getElementById('package_type');
            const mainDestinationDropdown = document.getElementById('destination_id');

            const oldMainDestination = "{{ old('destination_id', $package->destination_id ?? '') }}";

            function getDestinationsByType() {
                if (packageType.value === 'domestic') return domesticDestinations;
                if (packageType.value === 'international') return internationalDestinations;
                return [];
            }

            function populateMainDestination() {
                const list = getDestinationsByType();
                mainDestinationDropdown.innerHTML = '<option value="">Select Destination</option>';

                list.forEach(dest => {
                    const selected = oldMainDestination == dest.id ? 'selected' : '';
                    mainDestinationDropdown.innerHTML +=
                        `<option value="${dest.id}" ${selected}>${dest.name}</option>`;
                });
            }

            function createItineraryRow(selectedDest = '', nights = '') {
                const list = getDestinationsByType();

                let options = '<option value="">Select Destination</option>';
                list.forEach(dest => {
                    const selected = selectedDest == dest.id ? 'selected' : '';
                    options += `<option value="${dest.id}" ${selected}>${dest.name}</option>`;
                });

                const row = document.createElement('div');
                row.className = 'row mb-2 itinerary-row';

                row.innerHTML = `
            <div class="col-md-7">
                <select name="itineraries[${itineraryIndex}][destination_id]" class="form-control" required>
                    ${options}
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" name="itineraries[${itineraryIndex}][nights]" class="form-control" value="${nights}" placeholder="Nights" required>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-danger remove-row">×</button>
            </div>
        `;

                itineraryContainer.appendChild(row);
                itineraryIndex++;
            }

            function updateHotelMappings() {
                hotelBody.innerHTML = '';
                const rows = document.querySelectorAll('.itinerary-row');

                let uniqueDests = [];

                rows.forEach(row => {
                    const select = row.querySelector('select');
                    const destId = select.value;
                    const destName = select.options[select.selectedIndex]?.text;

                    if (destId && !uniqueDests.includes(destId)) {
                        uniqueDests.push(destId);

                        let tr = document.createElement('tr');
                        tr.innerHTML = `<td><strong>${destName}</strong></td>`;

                        categories.forEach(cat => {
                            let selectHtml =
                                `<select name="mapped_hotels[${destId}_${cat.id}][hotel_id]" class="form-control select-sm">`;
                            selectHtml += `<option value="">Select Hotel</option>`;

                            const destHotels = hotels.filter(h =>
                                String(h.destination_id) === String(destId) &&
                                String(h.hotel_category_id) === String(cat.id)
                            );

                            destHotels.forEach(h => {
                                const isSelected = existingMappings.find(m =>
                                    m.destination_id == destId &&
                                    m.hotel_category_id == cat.id &&
                                    m.hotel_id == h.id
                                );

                                selectHtml +=
                                    `<option value="${h.id}" ${isSelected ? 'selected' : ''}>${h.name}</option>`;
                            });

                            selectHtml +=
                                `</select>
                        <input type="hidden" name="mapped_hotels[${destId}_${cat.id}][destination_id]" value="${destId}">
                        <input type="hidden" name="mapped_hotels[${destId}_${cat.id}][hotel_category_id]" value="${cat.id}">`;

                            tr.innerHTML += `<td>${selectHtml}</td>`;
                        });

                        hotelBody.appendChild(tr);
                    }
                });
            }

            document.getElementById('add-itinerary').addEventListener('click', () => createItineraryRow());

            document.addEventListener('change', function(e) {
                if (e.target.closest('.itinerary-row select')) {
                    updateHotelMappings();
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.itinerary-row').remove();
                    updateHotelMappings();
                }
            });

            packageType.addEventListener('change', function() {
                populateMainDestination();
                itineraryContainer.innerHTML = '';
                createItineraryRow();
                updateHotelMappings();
            });

            // ✅ Edit mode load
            populateMainDestination();

            @if (isset($package) && $package->itineraries->count())
                @foreach ($package->itineraries as $it)
                    createItineraryRow("{{ $it->destination_id }}", "{{ $it->nights }}");
                @endforeach
            @else
                createItineraryRow();
            @endif

            updateHotelMappings();
        });
    </script>
@endsection
