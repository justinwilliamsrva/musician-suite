<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('musician-finder.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('musician-finder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = [
            'instruments' => ['Violin', 'Viola'],
        ];

        $jobs = [
            ['musicianNumber' => 1, 'instruments' => ['Violin', 'Viola'] ],
            ['musicianNumber' => 2, 'instruments' => ['Violin', 'Viola'] ],
            ['musicianNumber' => 3, 'instruments' => ['Violin', 'Viola'] ],
        ];

        return view('musician-finder.show', ['jobs' => $jobs, 'user' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobs = [
            ['musicianNumber' => 1],
            ['musicianNumber' => 2],
            ['musicianNumber' => 3],
            ['musicianNumber' => 4],
            ['musicianNumber' => 5],
            ['musicianNumber' => 6],
        ];

        return view('musician-finder.edit', ['jobs' => $jobs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('musician-finder.dashboard');
    }

    public function updateJob($id)
    {
        return redirect()->back();
    }
}
