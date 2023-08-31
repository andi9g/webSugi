<?php

namespace App\Http\Controllers;

use App\Models\produkM;
use App\Models\kategoriM;
use Illuminate\Http\Request;

class produkC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $produk = produkM::where("namaproduk", "like", "%$keyword%")->paginate(15);
        $kategori = kategoriM::get();
        $produk->appends($request->only("limit", "keyword"));
        return view("pages.produk.produk", [
            "produk" => $produk,
            "kategori" => $kategori,
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
        try {
            $data = $request->all();
            
            if($request->hasFile("gambar")) {
                $gambar = $request->gambar;
                $ex = $gambar->getClientOriginalExtension();
                $size = $gambar->getSize();
                $fileName = uniqid().".".$ex;

                if($size < 2000000) {
                    
                    if(strtolower($ex) == "jpg" || strtolower($ex) == "jpeg" || strtolower($ex) == "png") {
                        
                        $gambar->move(public_path()."/gambar/produk", $fileName);
                        $data["gambar"] = $fileName;

                        produkM::create($data);

                        return redirect()->back()->with("success", "Data berhasil ditambahkan")->withInput();
                    }
                }
            }

            return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
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
    public function update(Request $request, produkM $produkM, $idproduk)
    {
        try {
            $data = $request->all();
            $produk = produkM::where("idproduk", $idproduk)->first();
            $data["gambar"] = $produk->gambar;
            if($request->hasFile("gambar")) {
                $gambar = $request->gambar;
                $ex = $gambar->getClientOriginalExtension();
                $size = $gambar->getSize();
                $fileName = uniqid().".".$ex;
                $data["gambar"] = $fileName;

                if($size < 2000000) {
                    
                    if(strtolower($ex) == "jpg" || strtolower($ex) == "jpeg" || strtolower($ex) == "png") {
                        
                        $gambar->move(public_path()."/gambar/produk", $fileName);
                        
                    }
                }
            }

            $produk->update($data);

            return redirect()->back()->with("success", "Data berhasil diupdate")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
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
