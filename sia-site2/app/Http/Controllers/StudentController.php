<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

Class StudentController extends Controller {
    use ApiResponser;

    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function add(Request $request){ //ADD USER
        
        $rules = [
            'lastname' => 'required|max:20',
            'firstname' => 'required|max:20',
            'middlename' => 'required|max:20',
            'age' => 'required|max:20'
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return response()->json($user, 200);
    }
    
    public function updateUser(Request $request, $id) { //UPDATE USER
        $rules = [
            'lastname' => 'required|max:20',
            'firstname' => 'required|max:20',
            'middlename' => 'required|max:20',
            'age' => 'required|max:20'
        ];
    
        $this->validate($request, $rules);
    
        $user = User::findOrFail($id);
    
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return response()->json("At least one value must
            change", 403);
        } else {
            $user->save();
            return response()->json($user, 200);
        }
    }

    public function deleteUser($id) { // DELETE USER
        $users = User::where('studid', $id)->delete();
        if ($users){
            return $this -> successReponse($users);
        }
        {
            return $this-> errorResponse('User Does Not Exist', Response::HTTP_NOT_FOUND);
        } 
    }

    public function show($id){
        $users = User::where('studid', $id)->first();
        if ($users){
            return $this -> successReponse($users);
        }
        {
            return $this-> errorResponse('User Does Not Exist', Response::HTTP_NOT_FOUND);
        }
        
    }
}   


