@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>{{ $hotel->name }} – Room Types</h3>

        <a href="{{ route('hotel.rooms.create', $hotel->id) }}" class="btn btn-primary mb-3">
            Add Room
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Base Pax</th>
                    <th>Max Pax</th>
                    <th>Extra Adult Price</th>
                    <th>Child with bed price</th>
                    <th>Child no bed price</th>
                    <th>Infant price</th>
                    <th>Season Extra Adult Price</th>
                    <th>Season child with bed price</th>
                    <th>Season child no bed price</th>
                    <th>Season Base Price</th>
                    <th>Normal Price</th>
                    <th>Season</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roomTypes as $room)
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->base_pax }}</td>
                        <td>{{ $room->max_pax }}</td>
                        <td>₹{{ $room->extra_adult_price }}</td>
                        <td>₹{{ $room->child_with_bed_price }}</td>
                        <td>₹{{ $room->child_no_bed_price }}</td>
                        <td>₹{{ $room->infant_price }}</td>
                        <td>₹{{ $room->season_extra_adult_price }}</td>
                        <td>₹{{ $room->season_child_with_bed_price }}</td>
                        <td>₹{{ $room->season_child_no_bed_price }}</td>
                        <td>₹{{ $room->season_base_price }}</td>
                        <td>₹{{ $room->base_price }}</td>
                        <td>
                            @if ($room->season_start)
                                {{ $room->season_start }} → {{ $room->season_end }}
                            @else
                                Normal
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection