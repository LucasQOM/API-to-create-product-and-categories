<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Products;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductsController extends UserController
{
    public function index()
    {
        $products = Products::all();

        return response()->json(['status' => 200, 'data' => ProductResource::collection($products), 'message' => 'Produto listado com sucesso.']);
    }

    public function store(ProductCreateRequest $request)
    {
        try {
            $input = $request->validated();

            $input['file'] = [];
            $fileCount = 0;
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $file->move(public_path('products/'), $request->name . "_" . ++$fileCount . "." . $file->getClientOriginalExtension());
                    array_push($input['file'], 'products/' . $request->name . "_" . $fileCount . "." . $file->getClientOriginalExtension());
                }
            }

            $products = Products::create($input);
        } catch (\Exception $e) {
            if (env('APP_DEBUG')) {
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => $e->getMessage()]));
            } else
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => 'Ocorreu um erro ao gravar este produto!']));
        }

        return response()->json(['status' => 201, 'data' => new ProductResource($products), 'message' => 'Produto criado com sucesso.']);
    }

    public function show($id)
    {
        $product = Products::find($id);

        if (is_null($product)) {
            return response()->json(['status' => 404, 'data' => 'produto não encontrado!']);
        }

        return response()->json(['status' => 200, 'data' => $product, 'message' => 'produto selecionado com sucesso!']);
    }

    public function update(ProductEditRequest $request, $id)
    {
        try {
            $input = Products::find($id);
            $updatedProduct = $request->validated();

            if ($request->hasFile('file')) {
                $updatedProduct['file'] = array();
                $fileCount = 0;

                if (!is_null($input->file)) {
                    foreach ($input->file as $oldFile) {
                        if (file_exists(public_path($oldFile))) {
                            unlink(public_path($oldFile));
                        }
                    }
                }
                foreach ($request->file('file') as $file) {
                    $file->move(public_path('products/'), $request->name . "_" . ++$fileCount . "." . $file->getClientOriginalExtension());
                    array_push($updatedProduct['file'], 'products/' . $request->name . "_" . $fileCount . "." . $file->getClientOriginalExtension());
                }
            } else {
                unset($updatedProduct['file']);
            }

            $input->update($updatedProduct);
        } catch (\Exception $e) {
            if (env('APP_DEBUG')) {
                throw new HttpResponseException(response()->json(['error' => $e->getMessage()], 500));
            } else {
                throw new HttpResponseException(response()->json(['error' => 'An error ocurred, in the update product attempt!'], 500));
            }
        }
        return response()->json(['status' => 200, 'data' => $input , 'message' => 'Produto atualizado com sucesso!'], 201);
    }

    public function destroy(Products $products, $id)
    {
        $products = Products::findOrFail($id);
        $products->delete();
        return response()->json(['success' => 200, 'data' => 'produto deletado com sucesso!']);
    }
}
