<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        <tr>
            <td>{{ $sale['name'] }}</td>
            <td>{{ $sale['qnty'] }}</td>
            <td>{{ $sale['total'] }}</td>
        </tr>
    @endforeach
    </tbody>

    @php
        $total = 0;
        foreach($sales as $sale) {
            $total += $sale['total'];
        }
    @endphp
    <tfoot>
        <tr>
            <td colspan="2">Total</td>
            <td>{{ $total }}</td>
        </tr>
    </tfoot>

</table>
