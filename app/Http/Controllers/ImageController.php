<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {

       $project_id = \Auth::user()->project_id;
      // echo $project_id;die;
       if($request->get('image'))
       {
          $image = $request->get('image');
          $name = $request->get('image_file_name')."_".$project_id."_".time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          Image::make($request->get('image'))->save(public_path('image/'.$request->get('image_folder_name').'/').$name);
        }

       $image_arr= new FileUpload();
       $image_arr->image_name = $name;
      // print_r($image_arr);die;
       $image_arr->save();

       return "1**".$image_arr->id;
    }

    public function update(Request $request)
    {
      
       $image_id= $request->get('img_id');
       $project_id = \Auth::user()->project_id;
       if($request->get('image'))
       {
          $image = $request->get('image');
          $name =$request->get('image_file_name')."_".$project_id."_".time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          Image::make($request->get('image'))->save(public_path('image/'.$request->get('image_folder_name').'/').$name);
        }

       $image=FileUpload::where('id',$image_id)->update(['image_name'=>$name]);
    
       return "1**".$image_id;

    }

    public function storPhoto(Request $request)
    {
       if($request->get('emp_photo'))
       {
          $image = $request->get('emp_photo');
         // dd($image);
          $name = "emp_photo".time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          Image::make($request->get('emp_photo'))->save(public_path('employee_photo/').$name);
        }

       $image= new FileUpload();
       $image->image_name = $name;
       $image->save();

       return "1**".$image->id;
     }

   public function photo_upload(Request $request)
   {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            $image_arr= new FileUpload();
            $image_arr->image_name = $filename;
            $image_arr->save();

            return response()->json(['path' => "/storage/$path", 'filename' => $filename, 'image_id' => $image_arr->id]);
        }

        return response()->json(['error' => 'File upload failed'], 400);
    }

   public function file_upload(Request $request)
   {
      $request->validate([
            'file' => 'required|file|max:20048',
      ]);

      if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            $image_arr= new FileUpload();
            $image_arr->image_name = $filename;
            $image_arr->save();

            return response()->json(['path' => "/storage/$path", 'filename' => $filename, 'image_id' => $image_arr->id]);
      }

      return response()->json(['error' => 'File upload failed'], 400);
   }
    

    public function updatePhoto(Request $request)
    {
      
    	$photo_image_id= $request->get('emp_id');
       if($request->get('emp_photo'))
       {
          $image = $request->get('emp_photo');
          $name ="emp_photo".time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
          Image::make($request->get('emp_photo'))->save(public_path('employee_photo/').$name);
        }

       $image=FileUpload::where('id',$photo_image_id)->update(['image_name'=>$name]);
      // $image->image_name = $name;
      // $image->save();

       return "1**".$photo_image_id;
   }
}


