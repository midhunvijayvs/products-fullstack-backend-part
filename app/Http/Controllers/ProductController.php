<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File; 
use Storage;
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

    
    public function search()
    {
       
        $searchProduct = Product::query();
        if (request('term')) {
            $searchProduct->where('title', 'Like', '%' . request('term') . '%');
        }

        return $searchProduct->orderBy('id', 'DESC')->paginate(10);
    }
    


    
           


    public function searchPriceFilter(Request $request)
    {
        $min=$request->priceFrom;
        $max=$request->priceTo;
        $searchQuery=$request->searchQuery;

        $searchPriceProduct = Product::query();
       
            $searchPriceProduct->where('title', 'Like', '%' . $searchQuery . '%')
                            ->where('price','>=',$min)
                            ->where('price','<=',$max);
        
        
        
        return $searchPriceProduct->orderBy('id', 'DESC')->paginate(10);
    }



    public function searchSort(Request $request)
    {
        $sortKey=$request->sortKey;
        
        $searchQuery=$request->searchQuery;

        $searchSort = Product::query();
       
        $searchSort->where('title', 'Like', '%' . $searchQuery . '%');
        
        $result='null';

        if($sortKey=='PriceAscending'){

            $result=$searchSort->orderBy('price', 'ASC')->paginate(10);  
        }
        else if($sortKey=='PriceDescending'){
            $result= $searchSort->orderBy('price', 'DESC')->paginate(10);
        }
        return $result;
        
    }


    public function store(Request $request)
    {
        $addProductPost = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'short_note' => $request->short_note,
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

   

    public function storeBatch(Request $request)
    {
        $decoded_request_data=json_decode($request->data);   //  oposit action for JSON
      

        for($i=0;$i<count($decoded_request_data);$i++){
            $addProductPost = Product::create([
                'title' => $decoded_request_data[$i]->title,
                'description' => $decoded_request_data[$i]->description,
                'short_note' => $decoded_request_data[$i]->short_note,
                'price' => $decoded_request_data[$i]->price,
                'image_public_url' => 'dummy',
                'image_name'=> 'dummy',
                'vat_applicable' => $decoded_request_data[$i]->vat_applicable,
                'vat_percentage' => $decoded_request_data[$i]->vat_percentage
            ]);
           
        
            
            $image_64 = $decoded_request_data[$i]->image; //your base64 encoded data

            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
          
            $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
          
          // find substring fro replace here eg: data:image/png;base64,
          
           $image = str_replace($replace, '', $image_64); 
          
           $image = str_replace(' ', '+', $image); 
          

           $filename= $addProductPost->id.'.'.$extension;
           //$imageName = Str::random(10).'.'.$extension;
          
           Storage::disk('public')->put($filename, base64_decode($image));
          
            

            //base64_decode($image)-> move(public_path('\storage'), $filename);
            
            $addProductPost->image_public_url=asset('storage/'.$filename);    //asset(''storage/...')  is a buitin function to get the public url of the storage folder, its subfolders or files in it
            $addProductPost->image_name=$filename;
            $addProductPost->save();

        }

        
        return response()->json([
            'status'=>'success',
            // 'data'=> $decoded_request_data,
            
           
            // 'stored the Entry'=> $addProductPost
        ]
        ,200);
    }






    
     
    public function update(Request $request, $id)
    {
        $data=$request->all();

        

        $editProductPost = Product::where('id', $id)
              ->update(['title' => $request->title,
              'description' => $request->description,
              'short_note' => $request->short_note,
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
