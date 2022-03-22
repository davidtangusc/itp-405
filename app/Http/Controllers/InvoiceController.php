<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Illuminate\Support\Facades\Gate;
use Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        // $this->authorize('viewAny', Invoice::class);

        if (Auth::user()->cannot('viewAny', Invoice::class)) {
            abort(403);
        }

        $invoices = Invoice::with(['customer'])
            ->select('invoices.*')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            // ->where('customers.email', '=', Auth::user()->email)
            ->get();

        return view('invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with([
            'invoiceItems.track',
            'invoiceItems.track.album',
            'invoiceItems.track.album.artist',
        ])->find($id);

        // if (Gate::denies('view-invoice', $invoice)) {
        //     abort(403); // 403 Not Authorized
        // }

        // if (!Gate::allows('view-invoice', $invoice)) {
        //     abort(403); // 403 Not Authorized
        // }

        if (Auth::user()->cannot('view', $invoice)) {
            abort(403);
        }

        // if (!Auth::user()->can('view-invoice', $invoice)) {
        //     abort(403);
        // }

        // $this->authorize('view-invoice', $invoice);

        return view('invoice.show', [
            'invoice' => $invoice,
        ]);
    }
}
