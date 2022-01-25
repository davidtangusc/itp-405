@extends("layouts.main")

@section("title", "Invoices")

@section("content")
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>
                        {{$invoice->id}}
                    </td>
                    <td>
                        {{$invoice->first_name}} {{$invoice->last_name}}
                    </td>
                    <td>
                        {{$invoice->invoice_date}}
                    </td>
                    <td>
                        ${{$invoice->total}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection