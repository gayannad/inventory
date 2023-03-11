<div style="overflow-x:auto;">
    <div style="background-color: gainsboro"><span style="text-align: center;font-weight: bolder">Stock Report</span></div>
    <br>
    <table>
        <tr style="font-weight: bolder">
            <th>Product Code</th>
            <th>Description</th>
            <th>Selling Price</th>
            <th>Cost Price</th>
            <th>Qty</th>
        </tr>
        @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock->description }}</td>
                <td>{{ $stock->selling_price }}</td>
                <td>{{ $stock->cost_price }}</td>
                <td>{{ $stock->qty}}</td>
            </tr>

        @endforeach
    </table>
</div>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }
</style>