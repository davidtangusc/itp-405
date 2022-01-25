<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = DB::table('invoices')
            ->join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->get([
                'invoices.id AS id',
                'invoices.invoice_date',
                'customers.first_name',
                'customers.last_name',
                'invoices.total',
            ]);

        return view('invoice.index', [
            'invoices' => $invoices,
        ]);
    }

    public function show($id)
    {
        $invoice = DB::table('invoices')
            ->where('id', '=', $id)
            ->first();

        $invoiceItems = DB::table('invoice_items')
            ->where('invoice_id', '=', $id)
            ->join('tracks', 'tracks.id', '=', 'invoice_items.track_id')
            ->join('albums', 'tracks.album_id', '=', 'albums.id')
            ->join('artists', 'albums.artist_id', '=', 'artists.id')
            ->orderBy('track')
            ->get([
                'invoice_items.unit_price',
                'tracks.name AS track',
                'albums.title AS album',
                'artists.name AS artist',
            ]);

        return view('invoice.show', [
            'invoice' => $invoice,
            'invoiceItems' => $invoiceItems,
        ]);
    }
}
