<x-mail::message>
# Hi {{ $order->user->first_name }}

<p>Thanks for your order. It's on-hold until we confirm that payment has been received.</p>


<h2>Our bank details</h2>
<h2>E.F Enterprises:</h2>

<ul>
    <li>Bank: <strong>Bank Of America</strong></li>
    <li>Account numbe: <strong>237049617670</strong></li> 
    <li>Routing number: <strong>053000196</strong></li> 
    <li>IBAN: <strong>205 2nd St NW Hickory, NC 28601</strong></li>
</ul>


<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid black; padding: 5px;">Product</th>
            <th style="border: 1px solid black; padding: 5px;">Quantity</th>
            <th style="border: 1px solid black; padding: 5px;">Price</th>
            <th style="border: 1px solid black; padding: 5px;">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td style="border: 1px solid black; padding: 5px;">{{ $item->product->name }}</td>
                <td style="border: 1px solid black; padding: 5px;">{{ $item->quantity }}</td>
                <td style="border: 1px solid black; padding: 5px;">{{ $item->price }}</td>
                <td style="border: 1px solid black; padding: 5px;">{{ $item->subtotal * $item->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="border: 1px solid black; padding: 5px;">Total:</td>
            <td style="border: 1px solid black; padding: 5px;">{{ $order->amount }}</td>
        </tr>
    </tfoot>
</table>

<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
