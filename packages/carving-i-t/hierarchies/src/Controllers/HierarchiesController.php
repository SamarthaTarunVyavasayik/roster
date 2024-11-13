<?php
namespace CarvingIT\Hierarchies\Controllers;

use Illuminate\Http\Request;
use CarvingIT\Hierarchies\Models\Position;
use CarvingIT\Hierarchies\Models\PositionUser;
use App\Models\User;

class HierarchiesController
{
    public function index(Request $request){
        return view('vendor.hierarchies.index');
    }

    public function addPosition(Request $request){
        $position = new Position;
        $position->label = $request->label;
        $position->reports_to = $request->reports_to;
        $position->save();
        return redirect()->back();
    }

    public function removePosition(Request $request){
       Position::find($request->position_id)->delete();
        return redirect()->back();
    }

    public function removePositionUser(Request $request){
        PositionUser::find($request->position_user_id)->delete();
        return redirect()->back();
    }

    public function fillPosition(Request $request){
        try{
        $u = User::where('email',$request->user)->first();
        $position_user = new PositionUser;
        $position_user->position_id = $request->position_id;
        $position_user->user_id = $u->id;
        $position_user->save();
        }
        catch(\Exception $e){
            // do nothing
        }
        return redirect()->back();
    }

    public function suggestUser(Request $request){
        $term = $request->term;
        $users = User::where('name', 'like', '%'.$term.'%')
            ->orWhere('email', 'like', '%'.$term.'%')
            ->get(); 
        return ['suggestions'=>$users];
    }
}


