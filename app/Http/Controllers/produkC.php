<?php

namespace App\Http\Controllers;

use App\Models\produkM;
use App\Models\kategoriM;
use App\Models\notifikasiM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;

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

    public function diskon(Request $request, $idproduk)
    {
        $data = $request->all();
        $produk = produkM::where("idproduk", $idproduk)->first();
        $produk->update($data);

        return redirect()->back()->with("toast_success","berhasil menambahkan diskon")->withInput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sebarkandiskon(Request $request)
    {
        $users = User::select("email")->get();
        $recipients = $users->pluck('email')->toArray();

        $produk = produkM::where("diskon", ">", 0)->count();
        if($produk == 0) {
            return redirect()->back()->with("toast_warning","maaf tidak ada diskon")->withInput();
        }

        $produk = produkM::where("diskon", ">", 0)->get();

        $content = "";
        $notif = "";
        foreach ($produk as $p) {
            $hargaDiskon = $p->harga - ($p->harga * ($p->diskon / 100));
            $notif = $notif." Nama Produk : ".ucwords($p->namaproduk)."<br>";
            $notif = $notif." Diskon : ".$p->diskon."%<br>";
            $notif = $notif." Harga Produk :  <strike>Rp".number_format($p->harga,0,",",".")."</strike> >".number_format($hargaDiskon,0,",",".")."<br><br>";

            $content = $content." Nama Produk : ".ucwords($p->namaproduk)."\n";
            $content = $content." Diskon : ".$p->diskon."%\n";
            $content = $content." Harga Produk : Rp".number_format($p->harga,0,",",".")."\n";
            $content = $content." Harga Diskon : Rp".number_format($hargaDiskon,0,",",".")." ---";
        }
        
        $pesan = $request->pesan;

        $user = User::select("id")->get();
        foreach ($user as $u) {
            $iduser = $u->id;
            notifikasiM::create([
                'iduser' => $iduser,
                'invoice' => $pesan,
                'status' => $notif,
            ]);
        }
        
        

        $mailData = [
            'title' => $pesan,
            'content' => $content,
        ];
        
        Mail::to($recipients)
            ->send(new SampleMail($mailData));

            return redirect()->back()->with("success", "pesan telah dikirimkan")->withInput();
    }


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
    // public function show(produkM $produkM)
    // {
    //     //
    // }

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
