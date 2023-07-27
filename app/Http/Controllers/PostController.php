<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index () 
    {
        return view('post.index');
    }
    
    public function getall(Request $request) 
    {
        $data = Post::orderby('id', 'desc')->get();
        return DataTables::of($data)
           ->addColumn('action', function ($q) {
               $id = encrypt($q->id);
               return '
               <a href="javascript:void(0)" data-toggle="modal" data-id="' . $id . '" data-target=".add_modal" class="btn btn-success btn-sm openaddmodal" ><i class="fas fa-pencil-alt"></i></a> 
               <a href="javascript:void(0)" data-toggle="modal" data-id="' . $id . '" class="btn btn-danger btn-sm delete_record" ><i class="fas fa-trash-alt"></i></a>
               <a href="javascript:void(0)"  data-id="' . $id . '" class="btn btn-info btn-sm publishToProfile" ><i class="fab fa-facebook-square"></i></a>';
           })->addColumn('name', function ($q) {
               return $q->name;
           })->addColumn('image', function ($q) {
               if(!empty($q->image)){
                   if (File::exists('public/images/'.$q->image)) {
                       $image =$q->image;
                   }else {
                     $image = 'default.png';
                   }
               }else{
                   $image = 'default.png';
               }
               if (in_array($q->file_type, array("jpg", "jpeg", "png", "gif")))  {
                   return '<img src="'.url("public/images/".$image).'" class="rounded float-left" style=" width: 55px;" alt="...">';
               }else{
                   return '<video width="55" height="100"controls>
                       <source src="'.url("public/images/".$image).'" type="video/mp4">
                       <source src="'.url("public/images/".$image).'" type="video/ogg">
                       <source src="'.url("public/images/".$image).'" type="video/webm">
                       <object data="'.url("public/images/".$image).'" width="470" height="255">
                       <embed src="'.url("public/images/".$image).'" width="470" height="255">
                       </object>
                   </video>';
               }
           })->addColumn('message', function ($q) {
               return $q->message;
           }) ->addColumn('status', function ($q) {
               $id = encrypt($q->id);
               if ($q->status == 'active') {
                   return ' <a  class="badge badgesize badge-success right changestatus" data-status="inactive" data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
               }
               if ($q->status == 'inactive') {
                   return '<a class="badge badgesize badge-danger right changestatus"  data-status="active"  data-id="' . $id . '" href="javascript:void(0)">' . ucwords($q->status) . '</a>';
               }
           })->addIndexColumn()
           ->rawColumns(['status', 'action', 'image'])->make(true);
    }
}
