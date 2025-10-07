<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //dd($request->all());
        $request->validate([
            'nama'       => 'required|max:10',
            'email'      => ['required', 'email'],
            'pertanyaan' => 'required|max:300|min:8',
        ]);

        $data['nama']       = $request->nama;
        $data['email']      = $request->email;
        $data['pertanyaan'] = $request->pertanyaan;

        //return view('home-question-respon', $data);
        return redirect()->route('home')->with('info', 'Terimakasih karna telah bertanya rawwwrrrr <b>' . $data['nama'] . '</b>!
        Silahkan cek email anda di <b>' . $data['email'] . '</b> untuk respon lebih lanjut :)');
        //return redirect()->away('https://www.google.com/aclk?sa=L&ai=DChsSEwjtwcjD7ZCQAxVgq2YCHZwrO3gYACICCAEQARoCc20&co=1&ase=2&gclid=Cj0KCQjw0Y3HBhCxARIsAN7931V_hI-E633GtCfpcYBCMYh-R3jXnvqUU7ERJsnkZdJTWLG4t2rZ_wcaAqCKEALw_wcB&ei=AWLkaPW5FIfV4-EP3NSW4QU&cid=CAASN-RosBFOJj4jzdP60gD_uYyJ0jvdekNPV2Y2wpobTmtB_pwdG2m6Z5_b5PfU7a_40r1pXiPTtA0&cce=2&category=acrcp_v1_32&sig=AOD64_31XmaJBGlAxWcvsLEZV1YfaluBzQ&q&sqi=2&nis=4&adurl&ved=2ahUKEwi1vsPD7ZCQAxWH6jgGHVyqJVwQ0Qx6BAgMEAE');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
