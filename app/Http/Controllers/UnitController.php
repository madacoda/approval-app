<?php

namespace App\Http\Controllers;

use App\Repositories\SubdistrictRepository;
use App\Repositories\UnitRepository;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private $title = 'Unit';
    private $subdistrictRepository;

    function __construct()
    {
        $this->subdistrictRepository = new SubdistrictRepository();
    }

    function index()
    {
        $data = [
            'title' => $this->title,
            'data'  => $this->subdistrictRepository->paginate(),
        ];
        
        return view('master.unit.index', $data);
    }

    function create()
    {
        return view('master.unit.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        return redirect()->route('unit.index');
    }

    function edit($id)
    {
        return view('master.unit.edit');
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        return redirect()->route('unit.index');
    }

    function destroy($id)
    {
        return redirect()->route('unit.index');
    }
}
