<!DOCTYPE html>
<html>

<head>
    <title>Tour Package Quotation</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h2>Tour Package Quotation</h2>

    <table>
        <tr>
            <th>Package</th>
            <td>{{ $package->name }}</td>
        </tr>
        <tr>
            <th>Hotel Category</th>
            <td>{{ $hotel->name }}</td>
        </tr>
        <tr>
            <th>Vehicle</th>
            <td>{{ $vehicle->name }}</td>
        </tr>
    </table>

    <br>

    <h3>Total Price</h3>
    <h2>₹ {{ number_format($totalPrice, 2) }}</h2>

    <p>Generated on {{ now()->format('d M Y') }}</p>

</body>

</html>
