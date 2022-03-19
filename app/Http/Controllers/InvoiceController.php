<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Invoice::class);
        
        $invoices = Invoice::select('invoices.*')
            ->with(['customer'])
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            // ->where('customers.email', '=', Auth::user()->email)
            ->get();
        
        return view('invoice.index', [
            'invoices' => $invoices
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',
        ])->find($id);

        $this->authorize('view', $invoice);

        return view('invoice.show', [
            'invoice' => $invoice,
        ]);
    }
}
