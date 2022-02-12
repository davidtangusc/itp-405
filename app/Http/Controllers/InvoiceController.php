<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        // $invoices = DB::table('invoices')
        //     ->join('customers', 'invoices.customer_id', '=', 'customers.id')
        //     ->get([
        //         'invoices.id AS id',
        //         'invoices.invoice_date',
        //         'customers.first_name',
        //         'customers.last_name',
        //         'invoices.total',
        //     ]);

        $invoices = Invoice::with(['customer'])->get();

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

        return view('invoice.show', [
            'invoice' => $invoice,
        ]);
    }
}
