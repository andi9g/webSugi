<?php

namespace App\Http\Controllers;

use App\Models\topikdiskusiM;
use App\Models\User;
use App\Models\diskusiM;
use Auth;
use Illuminate\Http\Request;

class diskusiC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function topik(Request $request)
    {
        $iduser = Auth::user()->id;
        $topik = topikdiskusiM::orderBy("idtopikdiskusi", "desc")->where("iduser", $iduser)->get();

        return view("pages.topik", [
            "topik" => $topik,
        ]);
    }

    public function dokter(Request $request)
    {
        $topik = topikdiskusiM::orderBy("idtopikdiskusi", "desc")->where("ket", false)->get();

        return view("pages.dokter.diskusi", [
            "topik" => $topik,
        ]);
    }



    public function diskusi(Request $request, $idtopikdiskusi) {
        
        $diskusi = diskusiM::where("idtopikdiskusi", $idtopikdiskusi)->get();
        $topik = topikdiskusiM::where("idtopikdiskusi", $idtopikdiskusi)->first();
        return view("pages.chat", [
            "diskusi" => $diskusi,
            "topik" => $topik,
            "idtopikdiskusi" => $idtopikdiskusi,
        ]);
        
    }

    public function selesai(Request $request, $idtopikdiskusi) {
        
        $topik = topikdiskusiM::where("idtopikdiskusi", $idtopikdiskusi)->first();
        
        $topik->update([
            "ket" => 1,
        ]);
        return redirect()->back()->withInput();
        
    }

    public function chat(Request $request, $idtopikdiskusi) {
        
        $iduser = Auth::user()->id;
        $topik = topikdiskusiM::where("idtopikdiskusi", $idtopikdiskusi)->first();
        if($topik->ket == true && $topik->user->posisi != "dokter") {
            return redirect()->back()->with("warning", "Maaf, forum chat telah berakhir")->withInput();
        }

        $cek = topikdiskusiM::where("idtopikdiskusi", $idtopikdiskusi);
        if($cek->count() == 1) {
            $cek = $cek->first();
            if($cek->user->posisi == "user") {
                $cek = topikdiskusiM::where("iduser", $iduser)
                ->where("idtopikdiskusi", $idtopikdiskusi)->count();
                if($cek != 1) {
                    return redirect('diskusi')->with("error", "maaf, tidak ada diskusi");

                }
            }
            $tambah = new diskusiM;
            $tambah->idtopikdiskusi = $idtopikdiskusi;
            $tambah->iduser = $iduser;
            $tambah->diskusi = $request->diskusi;
            $tambah->save();
            return redirect()->back()->withInput();
        }else {
            return redirect('diskusi')->with("error", "maaf anda belum membuat topik diskusi");
        }

        
    }

    public function tambahtopik(Request $request)
    {
        $iduser = Auth::user()->id;
        $diskusi = $request->diskusi;
        

        $tambah = new topikdiskusiM;
        $tambah->judultopikdiskusi = $request->judultopikdiskusi;
        $tambah->iduser = $iduser;
        $tambah->ket = 0;
        $tambah->save();

        diskusiM::create([
            "idtopikdiskusi" => $tambah->idtopikdiskusi,
            "iduser" => $tambah->iduser,
            "diskusi" => $request->diskusi,
        ]);

        return redirect()->back()->with("success", "Diskusi berhasil ditambahakan")->withInput();


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
     * @param  \App\Models\topikdiskusiM  $topikdiskusiM
     * @return \Illuminate\Http\Response
     */
    public function show(topikdiskusiM $topikdiskusiM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\topikdiskusiM  $topikdiskusiM
     * @return \Illuminate\Http\Response
     */
    public function edit(topikdiskusiM $topikdiskusiM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\topikdiskusiM  $topikdiskusiM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, topikdiskusiM $topikdiskusiM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\topikdiskusiM  $topikdiskusiM
     * @return \Illuminate\Http\Response
     */
    public function destroy(topikdiskusiM $topikdiskusiM)
    {
        //
    }
}
