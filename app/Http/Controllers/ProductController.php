<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function insert(Request $request) {
        $request->validate([
            'name'          => 'required',
            'price'         => 'required',
            'description'   => 'required',
            "stock"         => 'required',
            'id_category'   => 'required|exists:categories,id'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->id_category = $request->id_category;
        $product->save();

        return response()->json([
            "status" => 200,
            "msg"   => "El producto $product->name se ha guardado bien perraca",
        ]);
    }

    // Read all the products
    public function read() {
        $products = DB::table('products')->get();

        return response()->json([
            "status" => 200,
            "msg"   => $products,
        ]);
    }
    
    // Update specific product
    public function update(Request $request) {
        $request->validate([
            'id_product' => 'required'
        ]);

        $set_clause_parts = [];
        foreach($request->all() as $key => $value) {
            if($key != "id_product") {
                $set_clause_parts[] = "{$key}='{$value}'";
            }
        }
        $set_clause = implode(', ', $set_clause_parts);

        $rows_affected = DB::update('UPDATE products SET '.$set_clause.' where id = ?', [$request->id_product]);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha actualizado con exito",
            ]);
        }

        return response()->json([
            "status" => 300,
            "msg"   => "No se ha encontrado el producto para actualizar",
        ]);
    }

    // Delete specific product
    public function delete(Request $request) {
        $request->validate([
            'id_product' => 'required'
        ]);

        $rows_affected = DB::delete('delete from products WHERE id = ' . $request->id_product);

        if($rows_affected > 0) {
            return response()->json([
                "status" => 200,
                "msg"   => "Se ha borrado con exito",
            ]);
        }

        return response()->json([
            "status" => 300,
            "msg"   => "No se ha encontrado el producto para borrar",
        ]);
    }
}

