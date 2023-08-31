<?php

namespace App\Http\Controllers;

use App\Models\produkM;
use App\Models\User;
// use App\Models\invoiceM;
use Illuminate\Http\Request;

class homeC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $produk = produkM::count();
        $dokter = User::where("posisi", "dokter")->count();
        $user = User::where("posisi", "user")->count();
        $admin = User::where("posisi", "admin")->count();

        return view("pages.home", [
            "produk" => $produk,
            "dokter" => $dokter,
            "user" => $user,
            "admin" => $admin,
        ]);
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
     * @param  \App\Models\produkM  $produkM
     * @return \Illuminate\Http\Response
     */
    public function show(produkM $produkM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\produkM  $produkM
     * @return \Illuminate\Http\Response
     */
    public function edit(produkM $produkM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\produkM  $produkM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, produkM $produkM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\produkM  $produkM
     * @return \Illuminate\Http\Response
     */
    public function destroy(produkM $produkM)
    {
        //
    }
}
