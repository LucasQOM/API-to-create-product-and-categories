<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoyRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Resources\CategoryResource;

class CategoriesController extends UserController
{
    public function index()
    {
        $categories = Categories::all();

        return response()->json(['status' => 200, 'data' => CategoryResource::collection($categories), 'message' => 'Categorias listada com sucesso.']);
    }


    public function store(CategoyRequest $request)
    {
        try {
            $input = $request->all();

            $categories = Categories::create($input);
        }catch (\Exception $e){
            if (env('APP_DEBUG')){
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => $e->getMessage()]));
            } else
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => 'Ocorreu um erro ao gravar essa categoria!']));
        }
        return response()->json(['success' => new CategoryResource($categories), 'Categoria criada com sucesso.'], 201);
    }

    public function show($id)
    {
        $categories = Categories::find($id);

        if (is_null($categories)) {
            return response()->json(['status' => 404, 'data' => 'categoria não encontrada!']);
        }

        return response()->json(['success' => 200, 'data' => $categories, 'message' => 'categoria selecionada com sucesso!']);
    }

    public function update(CategoyRequest $request, $id)
    {
        try {
            $input = Categories::findOrFail($id);

            $input->update($request->all());
        }catch (\Exception $e){
            if (env('APP_DEBUG')){
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => $e->getMessage()]));
            } else
                throw new HttpResponseException(response()->json(['status' => 500, 'data' => 'Ocorreu um erro ao atualizar essa categoria!']));
        }


        return response()->json(['success' => 200, 'data' => new CategoryResource($input), 'message' => 'categoria atualizada com sucesso!']);
    }

    public function destroy(Categories $categories, $id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return response()->json(['success' => 200, 'data' => 'produto deletado com sucesso!']);
    }
}

