<!DOCTYPE html>
<html>
<head>
    <title>{{ $package->name }} Itinerary</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2 f2 f2; }
        .total { text-align: right; margin-top: 20px; font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $package->name }}</h1>
        <p>Tour Breakdown & Pricing</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Destination</th>
                <th>Nights</th>
                <th>Hotel Assigned</th>
                <th>Estimated Price (Approx)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itineraryData as $item)
            <tr>
                <td>{{ $item['destination'] }}</td>
                <td>{{ $item['nights'] }}</td>
                <td>{{ $item['hotel'] }}</td>
                <td>₹ {{ number_format($item['price'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Grand Total: ₹ {{ number_format($totalAmount, 2) }}
    </div>

    <div style="margin-top: 40px;">
        <h3>Inclusions</h3>
        {!! nl2br(e($package->inclusions)) !!}
    </div>

    <div style="margin-top: 20px;">
        <h3>Exclusions</h3>
        {!! nl2br(e($package->exclusions)) !!}
    </div>
</body>
</html>
