<?php

namespace App\Http\Controllers\Admin\Content;
use App\Http\Controllers\Controller;
use App\Models\Video;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideosController extends Controller{
	public function __construct(){
		$this->middleware('auth');
	}
	public function index(){
		return view('admin.content.videos');
	}
	public function manage(\Illuminate\Http\Request $request){
		$parameters = $request->all();
		$args = [];$resmessage = "Sorry, Command not found";$resstatus = 400;
		if ($request->isMethod('post')) {
			$s = $parameters['s'];
			switch ($s) {
				case "list":
					$args = Video::all()->take(10);
					$resstatus = 200;
					break;
				case "add":
					$file = $request->file('img');
					$obj = new Video;
					$obj->name = $parameters["name"];
					$obj->body = $parameters["body"];
					if ($request->hasFile('img')) {
						$file = $request->file('img');
						$name = Str::uuid().'.'.$file->getClientOriginalExtension();
						$file->move(storage_path().'/uploads/', $name);
						$obj->img = 'storage/uploads/'.$name;
					}
					$obj->url = $parameters["url"];
					$obj->lang = $parameters["lang"];
					$obj->save();
					$args = ["message" => "OK, You have added video successfully"];
					$resstatus = 200;
					break;
				case "edit":
					$img 	= '';
					if ($request->hasFile('img')) {
						$file = $request->file('img');
						$name = Str::uuid().'.'.$file->getClientOriginalExtension();
						$file->move(storage_path().'/uploads/', $name);
						$img = 'storage/uploads/'.$name;
					}
					Video::where('id', $parameters["id"])
						->update([
							'name' => $parameters["name"],
							'body' => $parameters["body"],
							'url' => $parameters["url"],
							'img' => $img,
							'lang' => $parameters["lang"],
						]);
					$args = ["message" => "OK, You have edit video successfully"];
					$resstatus = 200;
					break;
				case "delete":
					$obj = Video::where(['id'=> $parameters["id"]])->first();
					$img_path = base_path($obj->img);
					if (file_exists($img_path) && $obj->img) {
						unlink($img_path);
					}
					\App\Models\Video::where(["id" => $parameters["id"]])->delete();
					$args = ["message" => "OK, You have delete video successfully"];
					$resstatus = 200;
					break;
				case "read":
					$args = \App\Models\Video::where(["id" => $parameters["id"]])->first();
					$resstatus = 200;
					break;
				default:
					break;
			}
		}
		return Response::json($args, $resstatus);
	}
}