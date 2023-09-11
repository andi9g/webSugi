<?php

namespace App\Http\Controllers;

use App\Models\produkM;
use App\Models\keranjangM;
use App\Models\invoiceM;
use App\Models\notifikasiM;
use App\Models\detailinvoiceM;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Midtrans\Config;
use Midtrans\Snap;

class indexC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function beranda(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;
        $produk = produkM::where("namaproduk", "like", "%$keyword%")->latest()->paginate(15);

        $produk->appends($request->only(["limit", "keyword"]));

        return view("pages.beranda", [
            "produk" => $produk,
            "keyword" => $keyword,
        ]);
    }

    public function show(Request $request, $idproduk)
    {
        $produk = produkM::where("idproduk", $idproduk)->first();

        return view("pages.show", [
            "produk" => $produk,
        ]);

    }

    public function tambahkeranjang(Request $request, $idproduk)
    {

        $iduser = Auth::user()->id;
        $keranjang = keranjangM::where("idproduk", $idproduk)->where("iduser", $iduser);
        $produk = produkM::where("idproduk", $idproduk);
        
        if($keranjang->count() == 0) {
            if($produk->first()->stok < 1){
                return redirect()->back()->with("error", "Stok Tidak Mencukupi")->withInput();
            }
            $tambah = new keranjangM;
            $tambah->iduser = $iduser;
            $tambah->idproduk = $idproduk;
            $tambah->jumlah = 1;
            $tambah->save();
        }else {
            
            $jumlahkeranjang = $keranjang->first()->jumlah + 1;
            if($jumlahkeranjang > $produk->first()->stok){
                return redirect()->back()->with("error", "Stok Tidak Mencukupi")->withInput();
            }
            $keranjang->update([
                "jumlah" => $jumlahkeranjang,
            ]);

        }

        
        return redirect("keranjang")->with("success", "Data berhasil ditambahkan")->withInput();
        

    }

    public function ubahkeranjang(Request $request, $idproduk)
    {
        $iduser = Auth::user()->id;
        $keranjang = keranjangM::where("idproduk", $idproduk)->where("iduser", $iduser);
        $produk = produkM::where("idproduk", $idproduk);
        
        $jumlahkeranjang = $request->jumlah;
        if($jumlahkeranjang > $produk->first()->stok){
            return redirect()->back()->with("error", "Stok Tidak Mencukupi")->withInput();
        }
        $keranjang->update([
            "jumlah" => $jumlahkeranjang,
        ]);

        return redirect()->back()->with("toast_success", "Jumlah berhasil ditambahkan")->withInput();

    }

    public function pembelian(Request $request, $idproduk)
    {
        $iduser = Auth::user()->id;
        $keranjang = keranjangM::where("idproduk", $idproduk)->where("iduser", $iduser);
        $produk = produkM::where("idproduk", $idproduk);
        
        if($keranjang->count() == 0) {
            if($produk->first()->stok < 1){
                return redirect()->back()->with("error", "Stok Tidak Mencukupi")->withInput();
            }
            $tambah = new keranjangM;
            $tambah->iduser = $iduser;
            $tambah->idproduk = $idproduk;
            $tambah->jumlah = 1;
            $tambah->save();
        }


        return redirect('keranjang');

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function keranjang(Request $request)
    {
        $iduser = Auth::user()->id;
        $keranjang = keranjangM::where("iduser", $iduser)->get();
        $point = $request->session()->has('point');
        if($point == false) {
            $request->session()->put('point', false);
        }

        return view("pages.keranjang", [
            "keranjang" => $keranjang,
        ]);
    }

    public function invoice(Request $request)
    {

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        
        $iduser = Auth::user()->id;
        $keranjang = keranjangM::where("iduser", $iduser)->get();
        $invoice = "INV".time();

        $item = [];
        $total = 0;
        foreach ($keranjang as $k) {
            if ($k->produk->diskon > 0) {
                $diskon = $k->produk->harga - ($k->produk->harga * ($k->produk->diskon / 100));
                $item[] = [
                    "id" => $k->produk->idproduk,
                    "price" => $diskon,
                    "quantity" => $k->jumlah,
                    "name" => $k->produk->namaproduk,
                ];
                
                
            }else {
                $item[] = [
                    "id" => $k->produk->idproduk,
                    "price" => $k->produk->harga,
                    "quantity" => $k->jumlah,
                    "name" => $k->produk->namaproduk,
                ];
                $diskon = $k->produk->harga;

            }

            $total = $total + ($k->jumlah * $diskon);
            detailinvoiceM::create([
                "invoice" => $invoice,
                "idproduk" => $k->produk->idproduk,
                "jumlah" =>  $k->jumlah,
            ]);
            
        }

        

        

        $point = 0;
        $idku = Auth::user()->id;
        if (!empty(Auth::user())) {
            $pointku = DB::table("point")->where("iduser", $idku);
            if($pointku->count() == 1) {
                $point = $pointku->first()->point;
            }else {
                DB::table("point")->insert([
                    "iduser" => $idku,
                    "point" => 0,
                ]);
            }
        }

        $status = "pending";

        

        if (Session::get('point')==true){
            $hitung = $total - $point;
            
            if($hitung <= 0) {
                $total = $total;
                $sisa = $hitung * -1;
                $status = "success";
                $pointku = DB::table("point")->where("iduser", $idku)->update([
                    "point" => $sisa,
                ]);
            }else {
                $sisa = 0;
                $total = $hitung;
            }

        }else{
            $sisa = $point + ($total * 0.03);
        }

        
        if (Session::get('point')==true){
            $transaction_details = array(
                'order_id'    => time(),
                "gross_amount" => $total,
            );
    
            $customer_details = array(
                'first_name'       => Auth::user()->name,
                'last_name'        => "",
                'email'            => Auth::user()->email,
                'phone'            => ""
            );
    
            $transaction_data = array(
                'transaction_details' => $transaction_details,
                'customer_details'    => $customer_details
            );

        }else {
            $transaction_details = array(
                'order_id'    => time(),
                "gross_amount" => $total,
            );
    
            $customer_details = array(
                'first_name'       => Auth::user()->name,
                'last_name'        => "",
                'email'            => Auth::user()->email,
                'phone'            => ""
            );
    
            $transaction_data = array(
                'transaction_details' => $transaction_details,
                'item_details'        => $item,
                'customer_details'    => $customer_details
            );

        }

        
        $snapToken = Snap::getSnapToken($transaction_data);
        keranjangM::where("iduser", $iduser)->delete();

        $tambah = new invoiceM;
        $tambah->status = $status;
        $tambah->snap = $snapToken;
        $tambah->invoice = $invoice;
        $tambah->iduser = Auth::user()->id;
        $tambah->total = $total;
        $tambah->save();

        return redirect('checkout/'.$snapToken."/bayar");
        
    }

    public function notifikasi(Request $request)
    {
        $iduser = Auth::user()->id;
        $notifikasi = notifikasiM::orderBy("idnotifikasi", "desc")->where("iduser", $iduser)->get();

        return view("pages.notifikasi", [
            "notifikasi" => $notifikasi,
        ]);

    }

    public function callback(Request $request, $idinvoice)
    {
        
        try{
            $ket = $request->ket;
            $invoice = invoiceM::where("idinvoice", $idinvoice)->first();

            $detailinvoice = detailinvoiceM::where("invoice", $invoice->invoice)->get();
            foreach ($detailinvoice as $di) {
                $jumlah = $di->jumlah;
                $data = produkM::where("idproduk", $di->idproduk)->first();
                $total = $data->stok - $jumlah;
                $data->update([
                    "stok" => $total,
                ]);
            }


            $total = $invoice->total;
            if($ket == "success") {
                $point = 0;
                $idku = Auth::user()->id;
                if (!empty(Auth::user())) {
                    $pointku = DB::table("point")->where("iduser", $idku);
                    if($pointku->count() == 1) {
                        $point = $pointku->first()->point;
                    }else {
                        DB::table("point")->insert([
                            "iduser" => $idku,
                            "point" => 0,
                        ]);
                    }
                }

                $status = "pending";

                

                if (Session::get('point')==true){
                    $hitung = $total - $point;
                    
                    if($hitung < 0) {
                        $total = 0;
                        $sisa = $hitung * -1;
                        $status = "success";
                        
                    }else {
                        $sisa = 0;
                        $total = $hitung;
                    }

                }else{
                    $sisa = $point + ($total * 0.03);
                }

                $pointku = DB::table("point")->where("iduser", $idku)->update([
                    "point" => $sisa,
                ]);

                $invoice->update([
                    "status" => $ket,
                ]);
            }else {

                $invoice->update([
                    "status" => $ket,
                ]);
            }

            return response()->json(['success'=>'Pembayaran berhasil']);;

        }catch(\Throwable $th){
            return response()->json(['success'=>'Terjadi kesalahan']);;
        }
    }

    public function bayar(Request $request, $snaptoken)
    {
        $invoice = invoiceM::where("snap", $snaptoken)->first();

        return view("pages.bayar", [
            "snaptoken" => $snaptoken,
            "invoice" => $invoice,
        ]);
    }



    public function hapussatuan(Request $request, $idkeranjang)
    {
        $iduser = Auth::user()->id;
        keranjangM::where("iduser", $iduser)->where("idkeranjang", $idkeranjang)->delete();
        return redirect()->back()->with("toast_success", "Data berhasil dihapus")->withInput();
    }

    public function hapuskeranjang(Request $request)
    {
        $iduser = Auth::user()->id;
        keranjangM::where("iduser", $iduser)->delete();
        return redirect()->back()->with("toast_success", "Data berhasil dihapus")->withInput();
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
