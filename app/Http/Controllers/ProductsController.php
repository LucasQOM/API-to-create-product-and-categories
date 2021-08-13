<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Resources\ProductResource;
use Validator;

class ProductsController extends UserController
{
    public function index()
    {
        $products = Products::all();

        return $this->sendResponse(ProductResource::collection($products), 'Produtos listados com sucesso.');
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'categories_id' => 'required',
            'code' => 'required',
            'composition' => 'required',
            'price' => 'required',
            'size' => 'required',
            'file' => 'file|mimes:jpg',
        ]);
        if($validator->fails()){
            return $this->sendError('Erro.', $validator->errors());
        }

        $products = Products::create($input);


        return $this->sendResponse(new ProductResource($products), 'Produto criado com sucesso.');
    }

    public function show($id)
    {
        $product = Products::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Produto selecionado com sucesso.');
    }

    public function update(Request $request, Products $products, $id)
    {
        $input = Products::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'categories_id' => 'required',
            'code' => 'required',
            'composition' => 'required',
            'price' => 'required',
            'size' => 'required',
            'file' => 'file|mimes:jpg',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $products->name = $request->input('name');
        $products->categories_id = $request->input('categories_id');
        $products->code = $request->input('code');
        $products->composition = $request->input('composition');
        $products->price = $request->input('price');
        $products->size = $request->input('size');
        $products->file = $request->input('file');
        $products->update();

        return $this->sendResponse(new ProductResource($products), 'Produto atualizado com sucesso.');
    }

    public function destroy(Products $products, $id)
    {
        $products = Products::findOrFail($id);
        $products->delete();
        return $this->sendResponse([], 'Produto deletado com sucesso.');
    }
}
