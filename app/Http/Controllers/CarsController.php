<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;//find or fail error exception class.
use App\Http\Requests\CreateValidationRequest;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
        return view('cars.index')->with('cars', $cars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $car = new Car;
        // $car->name = $request->input('name');
        // $car->founded = $request->input('founded');
        // $car->description = $request->input('description');
        // $car->save();
/*
        $myimage = $request->file('myimage'); //get all image information
        $myimage = $request->file('myimage')->guessExtension(); //get the extension of file
        $myimage = $request->file('myimage')->getMimeType(); //get what type of file is uploaded and extension, similar to getClientMimeType
        $myimage = $request->file('myimage')->getClientOriginalName(); //get filename with extension
        getClientOriginalExtension
        $myimage = $request->file('myimage')->getSize(); //get size in kilobytes
        $myimage = $request->file('myimage')->getError(); //get Error return 0 if success
        $myimage = $request->file('myimage')->isValid(); //get Error return true if success
        $myimage = $request->file('myimage')->extension(); //get the extension of file
*/




        $file = $request->file('myimage');
        $newImageName = time() . '-' . $request->name . '.' . $request->myimage->extension();
        $file->move(public_path('images'), $newImageName);
        
    

      
        $request->validate([
            'name' => 'required|unique:cars',
            'founded' => 'required|integer',
            'description' => 'required',
            'myimage' => 'required|mines:jpg,png,jpeg|max:5048'
        ],[
            'name.required' => 'Walang laman ang Name field mo!',
            'founded.required' => 'Walang laman ang founded field mo!',
            'founded.integer' => 'dapat number and founded mo di pwedeng letters',
            'description.required' => 'Walang laman ang description field mo!'
        ]);

        $car = Car::create([
        'name'=> $request->input('name'),
        'founded' => $request->input('founded'),
        'description' => $request->input('description'),
        'myimage_path' => $newImageName
        ]);

        return redirect('/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        

        try{
            $car = Car::findOrFail($id);
            return view('cars.edit')->with('car', $car);
        }
        catch(ModelNotFoundException $err){
            return redirect('/cars');
        }
        // dd('aa');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateValidationRequest $request, $id)   
    {
        $validated = $request->validated();

        $car = Car::where('id',$id)
            ->update([
                'name'=> $request->input('name'),
                'founded' => $request->input('founded'),
                'description' => $request->input('description'),
            ]);
    
            return redirect('/cars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        $car->delete();

        return redirect('/cars');
    }
}
