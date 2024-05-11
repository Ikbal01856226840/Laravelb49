<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Table;

class TableController extends Controller
{
    public function index(){
        $title = 'Tables';

        $user_id = auth()->user()->id;

        $tables = Table::where('user_id', '=', $user_id)->get();

        return view('table_list', ['tables' => $tables, 'title'=>$title]);
    }

    public function createTable(){
        $title = 'Tables';

        return view('create_table', ['title'=>$title]);
    }

    public function saveTable(Request $request){
        $this->validate($request, [
            'table' => 'required',
        ]);

        $user_id = auth()->user()->id;

        $table = new Table();
        $table->table = $request->table;
        $table->user_id = $user_id;
        $table->save();

        Session::put('success_message', 'Successfully Saved!');

        return redirect()->back();
    }

    public function editTable($id)
    {
        $title = 'Edit Tables';

        $table = Table::find($id);

        return view('edit_table', ['table' => $table, 'title'=>$title]);
    }

    public function updateTable(Request $request, $id)
    {
        $this->validate($request, [
            'table' => 'required',
        ]);

        $table = Table::find($id);
        $table->table = $request->table;
        $table->save();

        Session::put('success_message', 'Successfully Updated!');

        return redirect()->back();
    }

    public function deleteTable($id){
        $res = Table::destroy($id);

        Session::put('success_message', 'Successfully Deleted!');

        return redirect('/tables');
    }
}