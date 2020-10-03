<?php

namespace App\Http\Controllers;

use App\Hobby;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class HobbyController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      //  $hobbies = Hobby::all();
       // $hobbies = Hobby::paginate(10);
        $hobbies = Hobby::orderBy('created_at','DESC')->paginate(10);
      //  dd($hobbies);
        return view('hobby.index')->with([
        'hobbies'=>$hobbies
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
        return view('hobby.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

       $request->validate([
       'name'=>'required|min:3',
       'description'=>'required|min:5',
       'image'=>'mimes:jpeg,jpg,bmp,png,gif',
       ]);

        $hobby = new Hobby([
        'name'=>$request['name'],
        'description'=>$request['description'],
        'user_id'=>auth()->id()
        ]);
        $hobby->save();
        if($reuest->image){
            $this->saveImage($request->image,$hobby->id);
        }
        /*return $this->index()->with([
         'message_success'=>"The Hobby <b>".$hobby->name."</b> is created"
        ]);*/

        return redirect('/hobby/'.$hobby->id)->with([
         'message_warning'=>"Please Assign some new tags "
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function show(Hobby $hobby)
    {
        //
       $allTags = Tag::all();
       $usedTags = $hobby->tags;

       $availableTags = $allTags->diff($usedTags);

        return view('hobby.show')->with([
           'hobby' =>$hobby,
           'availableTags' => $availableTags,
           'message_success'=>Session::get('message_success'),
           'message_warning'=>Session::get('message_warning')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function edit(Hobby $hobby)
    {
        //
        return view('hobby.edit')->with([
         'hobby'=>$hobby,
         'message_warning'=>Session::get('message_warning'),
         'message_success'=>Session::get('message_success'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hobby $hobby)
    {
        //
        $request->validate([
         'name'=>'required|min:3',
         'description'=>'required|min:2',
         'image'=>'mimes:jpeg,jpg,bmp,png,gif',
        ]);

        if($request->image){
            $this->saveImage($request->image,$hobby->id);
        }

        $hobby->update([
         'name'=>$request['name'],
         'description'=>$request['description'],
         'user_id'=>auth()->id()
        ]);
        return $this->index()->with([
         'message_success'=>'The hobby <b>'.$hobby->name.'</b> updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hobby  $hobby
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hobby $hobby)
    {
        //
        $oldName = $hobby->name;
        $hobby->delete();
        return $this->index()->with([
          'message_success'=>'The Hobby <b>'.$oldName.'</b> deleted'
        ]);
    }

    public function saveImage($imageInput,$hobby_id){
       $image = Image::make($imageInput);
            if($image->width() > $image->height()){
               // dd("landscape");
                $image->widen(1200)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_large.jpg")
                      ->widen(400)->pixelate(12)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_pixelate.jpg");

                $image = Image::make($imageInput);
                $image->widen(60)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");
            }else{
                //dd("potrait");
                 $image->heighten(900)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_large.jpg")
                      ->heighten(400)->pixelate(12)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_pixelate.jpg");

                $image = Image::make($imageInput);
                $image->heighten(60)
                      ->save(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");
            }
    }

    public function deleteImages($hobby_id){
        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_large.jpg")){
            unlink(public_path()."/img/hobbies/".$hobby_id."_large.jpg");
        }
        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg")){
            unlink(public_path()."/img/hobbies/".$hobby_id."_thumb.jpg");
        }
        if(file_exists(public_path()."/img/hobbies/".$hobby_id."_pixelate.jpg")){
            unlink(public_path()."/img/hobbies/".$hobby_id."_pixelate.jpg");
        }
        return back()->with([
        'message_success'=>'Image get deleted'
        ]);
    }
}
