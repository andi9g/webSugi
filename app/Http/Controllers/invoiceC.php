<?php

namespace App\Http\Controllers;

use App\Models\invoiceM;
use App\Models\detailinvoiceM;
use App\Models\notifikasiM;
use Illuminate\Http\Request;

class invoiceC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $invoice = invoiceM::join("users", "users.id", "invoice.iduser")->where("users.name", "like", "%$keyword%")->paginate(15);

        $invoice->appends($request->all());

        return view("pages.transaksi.transaksi", [
            "invoice" => $invoice,
        ]);
    }

    public function lihatpembelian(Request $request, $invoice)
    {
        $detail = detailinvoiceM::where("invoice", $invoice)->get();
        $status = invoiceM::where("invoice", $invoice)->first()->status;

        if($status == "success") {
            $warna = "bg-success";
        }elseif($status == "pending") {
            $warna = "bg-warning";
        }else {
            $warna = "bg-danger";
        }
        return view("pages.lihatpembelian", [
            "detail" => $detail,
            "invoice" => $invoice,
            "warna" => $warna,
        ]);
    }

    public function lihat(Request $request, $invoice)
    {
        $detail = detailinvoiceM::where("invoice", $invoice)->get();
        $status = invoiceM::where("invoice", $invoice)->first()->status;

        if($status == "success") {
            $warna = "bg-success";
        }elseif($status == "pending") {
            $warna = "bg-warning";
        }else {
            $warna = "bg-danger";
        }
        return view("pages.transaksi.lihat", [
            "detail" => $detail,
            "invoice" => $invoice,
            "warna" => $warna,
        ]);
    }

    public function notifikasi(Request $request, $iduser)
    {
        $data = $request->all();
        $data["iduser"] = $iduser;
        notifikasiM::create($data);

        return redirect()->back()->with("success", "Data telah dikirimkan")->withInput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoiceM  $invoiceM
     * @return \Illuminate\Http\Response
     */
    public function show(invoiceM $invoiceM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoiceM  $invoiceM
     * @return \Illuminate\Http\Response
     */
    public function edit(invoiceM $invoiceM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoiceM  $invoiceM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoiceM $invoiceM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoiceM  $invoiceM
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoiceM $invoiceM)
    {
        //
    }
}
