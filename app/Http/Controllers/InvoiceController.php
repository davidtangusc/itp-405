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
            'invoices' => $invoices
        ]);
    }
}
