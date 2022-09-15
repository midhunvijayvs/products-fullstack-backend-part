<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all(); //fetch all products from DB
          
        return ($products);
    }

    
    public function search($query)
    {
        $searchProduct = Product::Find('title', $query);

        return ($searchProduct);

    
   
    
  

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addProductPost = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'short_notes' => $request->short_notes,
            'price' => $request->price,
            'image_public_url' => 'dummy',
            'image_name'=> 'dummy',
        ]);
        

        $file= $request->file('image');                             //pick the file with key 'image' from $request
        $filename= $addProductPost->id.'.'.$file->getClientOriginalExtension();    // dynamically setting  filename for image to save
                                              
        //$destinationPath = public_path('\public\img');            //destination path to save the image
        $file-> move(public_path('\storage'), $filename);
        
        $addProductPost->image_public_url=asset('storage/'.$filename);    //asset(''storage/...')  is a buitin function to get the public url of the storage folder, its subfolders or files in it
        $addProductPost->image_name=$filename;
        $addProductPost->save();


        return response()->json([
            'status'=>'success',


            'stored the Entry'=> $addProductPost
        ]
        ,200);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();

        unset($data['_method']);

        $editProductPost = Product::where('id', $id)
              ->update(['title' => $request->title,
              'description' => $request->description,
              'short_notes' => $request->short_notes,
              'price' => $request->price,
             
              
            ]);
       
        



        $file= $request->file('image');                             //pick the file with key 'image' from $request
        $filename= $id.'.'.$file->getClientOriginalExtension();    // dynamically setting  filename for image to save
                                              
        //$destinationPath = public_path('\public\img');            //destination path to save the image
        $file-> move(public_path('\storage'), $filename);
        
       
        
        
        return response()->json([
            'status'=>'success',
            'stored the Entry'=> $editProductPost
        ]
        ,200);
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $item = Product::find($id);
        File::delete(public_path('\storage/'.$item->image_name));
        $item->delete();

        return response()->json([
            'status'=>'success',


            'deleted file url'=> public_path('\storage/'.$item->image_name)
        ]
        ,200);


        
        
        
        
        
        
    }
}
