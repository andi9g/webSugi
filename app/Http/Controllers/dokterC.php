<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class dokterC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dokter = User::where("posisi", "dokter")->get();
        return view("pages.dokter.dokter", [
            "dokter" => $dokter,
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
            $data["password"] = Hash::make($request->password);
            $data["posisi"] = "dokter";
            User::create($data);
            
            return redirect()->back()->with("success", "Data berhasil ditambahkan")->withInput();

        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "terjadi kesalahan")->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, $iduser)
    {
        try {
            $data = $request->all();
            $data["password"] = Hash::make($request->password);
            $update = User::where("id", $iduser)->first();
            $update->update($data);
            
            return redirect()->back()->with("success", "Data berhasil diubah")->withInput();
            
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();
            
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $iduser)
    {
        try {
            User::destroy($iduser);
            return redirect()->back()->with("success", "Data berhasil dihapus")->withInput();
            
        } catch (\Throwable $th) {
            return redirect()->back()->with("error", "Terjadi kesalahan")->withInput();
            
        }

    }
}
