<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function insert(Request $request) {
        $request->validate([
            'name' => 'required',
            'type' => 'required'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->type = $request->type;
        $category->save();

        return response()->json([
            "status" => 200,
            "msg"   => "La categoria $category->name se ha guardado bien perraca",
        ]);
    }

    // Read all the categories
    public function read() {
        $categories = DB::table('categories')->get();

        return response()->json([
            "status" => 200,
            "msg"   => $categories,
        ]);
    }
    
    // Update specific category
    public function update(Request $request) {
        $request->validate([
            'id_category' => 'required'
        ]);

        $set_clause_parts = [];
        foreach($request->all() as $key => $value) {
            if($key != "id_category") {
                $set_clause_parts[] = "{$key}='{$value}'";
            }
        }
        $set_clause = implode(', ', $set_clause_parts);

        $rows_affected = DB::update('update categories set '.$set_clause.' where id = ?', [$request->id_category]);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha actualizado con exito",
            ]);
        }

        return response()->json([
            "status" => 300,
            "msg"   => "No se ha encontrado la categoria para actualizar",
        ]);
    }

    // Delete specific category
    public function delete(Request $request) {
        $request->validate([
            'id_category' => 'required'
        ]);

        $rows_affected = DB::delete('delete from categories WHERE id = ' . $request->id_category);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha borrado con exito",
            ]);
        }

        return response()->json([
            "status" => 300,
            "msg"   => "No se ha encontrado la categoria para borrar",
        ]);
    }
}
