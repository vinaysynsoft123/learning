@extends('layouts.app')

@section('content')
    <div class="container pb-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ isset($package) ? 'Edit Package' : 'Add Package' }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($package) ? route('packages.update', $package) : route('packages.store') }}">
                    @csrf
                    @isset($package)
                        @method('PUT')
                    @endisset

                    <div class="row">
                          <div class="col-md-6 mb-3">
                            <label class="form-label">Destionation</label>
                            <select name="destination_id" class="form-control" required>
                                <option value="">Select Destination</option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination->id }}" @selected(old('destination_id', $package->destination_id ?? '') == $destination->id)>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $package->name ?? '') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total Nights</label>
                            <input type="number" name="nights" class="form-control" value="{{ old('nights', $package->nights ?? '') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Base Price</label>
                            <input type="number" step="0.01" name="base_price" class="form-control" value="{{ old('base_price', $package->base_price ?? '') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Discount</label>
                            <input type="number" step="0.01" name="discount" class="form-control" value="{{ old('discount', $package->discount ?? '') }}">
                        </div>
                    </div>

                    <hr>
                    <h5>1. Night Management (Itinerary)</h5>
                    <div id="itinerary-container">
                        @php
                            $itineraries = isset($package) ? $package->itineraries : (old('itineraries') ?? []);
                        @endphp
                        
                        @forelse($itineraries as $index => $item)
                            <div class="row mb-2 itinerary-row">
                                <div class="col-md-7">
                                    <select name="itineraries[{{ $index }}][destination_id]" class="form-control" required>
                                        <option value="">Select Destination</option>
                                        @foreach($destinations as $dest)
                                            <option value="{{ $dest->id }}" @selected(($item->destination_id ?? $item['destination_id']) == $dest->id)>{{ $dest->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="itineraries[{{ $index }}][nights]" class="form-control" placeholder="Nights" value="{{ $item->nights ?? $item['nights'] }}" required>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>
                            </div>
                        @empty
                            <div class="row mb-2 itinerary-row">
                                <div class="col-md-7">
                                    <select name="itineraries[0][destination_id]" class="form-control" required>
                                        <option value="">Select Destination</option>
                                        @foreach($destinations as $dest)
                                            <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="itineraries[0][nights]" class="form-control" placeholder="Nights" required>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger remove-row">×</button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="add-itinerary">Add Destination Stop</button>

                    <hr class="mt-4">
                    <h5>2. Hotel Assignment per Category</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Destination</th>
                                    @foreach($categories as $cat)
                                        <th>{{ $cat->name }} Hotel</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="hotel-mapping-body">
                                {{-- Filled via JS based on Itinerary Destinations --}}
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $package->description ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Inclusions</label>
                            <textarea name="inclusions" class="form-control" rows="4">{{ old('inclusions', $package->inclusions ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Exclusions</label>
                            <textarea name="exclusions" class="form-control" rows="4">{{ old('exclusions', $package->exclusions ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
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
            let itineraryIndex = {{ isset($package) ? count($package->itineraries) : 1 }};
            const container = document.getElementById('itinerary-container');
            const addBtn = document.getElementById('add-itinerary');
            const hotelBody = document.getElementById('hotel-mapping-body');

            const categories = @json($categories);
            const hotels = @json($hotels);
            const destinations = @json($destinations);
            const existingMappings = @json(isset($package) ? $package->mappedHotels : []);

            // Function to rebuild hotel mapping table
            function updateHotelMappings() {
                const rows = document.querySelectorAll('.itinerary-row');
                hotelBody.innerHTML = '';
                
                let uniqueDests = [];
                rows.forEach(row => {
                    const destId = row.querySelector('select').value;
                    const destName = row.querySelector('select option:checked').text;
                    if (destId && !uniqueDests.includes(destId)) {
                        uniqueDests.push(destId);
                        
                        let tr = document.createElement('tr');
                        let tdName = document.createElement('td');
                        tdName.innerHTML = `<strong>${destName}</strong>`;
                        tr.appendChild(tdName);

                        categories.forEach(cat => {
                            let td = document.createElement('td');
                            let selectHtml = `<select name="mapped_hotels[${destId}_${cat.id}][hotel_id]" class="form-control select-sm">`;
                            selectHtml += `<option value="">Select Hotel</option>`;
                            
                            // Filter hotels for this destination and this specific category
                            const destHotels = hotels.filter(h => 
                                String(h.destination_id) === String(destId) && 
                                String(h.hotel_category_id) === String(cat.id)
                            );
                            
                            destHotels.forEach(h => {
                                // Check if this hotel was already mapped
                                const isSelected = existingMappings.find(m => 
                                    m.destination_id == destId && 
                                    m.hotel_category_id == cat.id && 
                                    m.hotel_id == h.id
                                );
                                selectHtml += `<option value="${h.id}" ${isSelected ? 'selected' : ''}>${h.name}</option>`;
                            });
                            
                            selectHtml += `</select>`;
                            // Hidden fields for destination and category
                            selectHtml += `<input type="hidden" name="mapped_hotels[${destId}_${cat.id}][destination_id]" value="${destId}">`;
                            selectHtml += `<input type="hidden" name="mapped_hotels[${destId}_${cat.id}][hotel_category_id]" value="${cat.id}">`;
                            
                            td.innerHTML = selectHtml;
                            tr.appendChild(td);
                        });
                        hotelBody.appendChild(tr);
                    }
                });
            }

            addBtn.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'row mb-2 itinerary-row';
                newRow.innerHTML = `
                    <div class="col-md-7">
                        <select name="itineraries[${itineraryIndex}][destination_id]" class="form-control" required>
                            <option value="">Select Destination</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="itineraries[${itineraryIndex}][nights]" class="form-control" placeholder="Nights" required>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-danger remove-row">×</button>
                    </div>
                `;
                container.appendChild(newRow);
                itineraryIndex++;
                updateRowListeners();
            });

            function updateRowListeners() {
                document.querySelectorAll('.remove-row').forEach(btn => {
                    btn.onclick = function() {
                        if (document.querySelectorAll('.itinerary-row').length > 1) {
                            this.closest('.itinerary-row').remove();
                            updateHotelMappings();
                        }
                    };
                });

                document.querySelectorAll('.itinerary-row select').forEach(select => {
                    select.onchange = updateHotelMappings;
                });
            }

            updateRowListeners();
            updateHotelMappings();
        });
    </script>
@endsection
