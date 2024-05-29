<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\csf;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return response()->view('frontend.Section', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(csf $csf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(csf $csf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, csf $csf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(csf $csf)
    {
        //
    }
}
