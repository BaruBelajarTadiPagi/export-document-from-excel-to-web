<?php

namespace App\Http\Controllers;

use App\Exports\TeamsExport;
use App\Http\Requests\TeamFormRequest;
use App\Imports\TeamsImport;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class FrontendController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('index', compact('teams'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(TeamFormRequest $request)
    {
        $validatedData = $request->validated();

        
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() .'.'. $ext;
            
            $file->move('uploads/team/', $filename);
            $validatedData['image'] = "uploads/team/$filename";
        }

        Team::create([
            'name' => $validatedData['name'],
            'position' => $validatedData['position'],
            'image' => $validatedData['image'],
        ]);

        return redirect('/')->with('message', 'Person Added Successfully');
    }

    public function edit(Team $teams)
    {
        return view('edit', compact('teams'));
    }

    public function update(TeamFormRequest $request, Team $teams)
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')){

            $path = $teams->image;
            if(File::exists($path)){
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;

            $file->move('uploads/team/', $filename);
            $validatedData['image'] = "uploads/team/$filename";
        }

        Team::where('id', $teams->id)->update([
            'name' => $validatedData['name'],
            'position' => $validatedData['position'],
            'image' => $validatedData['image'],
        ]);

        return redirect('/')->with('message', 'Person Updated Successfully');
    }

    public function destroy(Team $teams)
    {
        if($teams->count() > 0){
            $destination = $teams->image;
            if(File::exists($destination)){
                File::delete($destination);
            }
            $teams->delete();
            return redirect('/')->with('message', 'Person Deleted Successfully');
        }
        $teams->delete();
        return redirect('/')->with('message', 'Something Went Wrong');
    }

    public function export() 
    {
        return Excel::download(new TeamsExport, 'report-team.xlsx');
    }

    public function import(Request $request) 
    {
        $request->validate([
            'filexls' => 'required|mimes:xls,xlsx',
        ], [
            'filexls.required' => 'File wajib diisi',
        ]);

        $files = $request->filexls;
        $filename = $files->getClientOriginalName();

        Excel::import(new TeamsImport, $files->move(public_path('files'), $filename));
        
        return redirect('/')->with('success', 'Import Success');
    }
}
