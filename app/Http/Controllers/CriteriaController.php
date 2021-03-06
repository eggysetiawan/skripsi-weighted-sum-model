<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CriteriaRequest;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criterias = Criteria::query()
            ->with('score')
            ->orderBy('name', 'asc')->get();
        return view('criterias.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('criterias.create', [
            'criteria' => new Criteria(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CriteriaRequest $request)
    {
        $attr = $request->validated();
        $attr['slug'] = Str::slug($request->name);
        Criteria::create($attr);

        session()->flash('success', 'Kriteria telah berhasil dibuat!');
        return redirect()->route('criterias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Criteria $criteria)
    {
        return view('criterias.edit', compact('criteria'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function update(CriteriaRequest $request, Criteria $criteria)
    {
        $attr = $request->validated();

        $criteria->update($attr);
        session()->flash('success', 'Kriteria telah berhasil di update!');

        return redirect()->route('criterias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Criteria  $criteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        session()->flash('success', 'Kriteria berhasil dihapus!');
        return redirect('criterias');
    }
}
