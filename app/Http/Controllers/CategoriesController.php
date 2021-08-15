<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Resources\CategorieResource;
use Validator;

class CategoriesController extends UserController
{
    public function index()
    {
        $categories = Categories::all();

        return $this->sendResponse(CategorieResource::collection($categories), 'Categorias listadas com sucesso.');
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError('Erro.', $validator->errors());
        }

        $categories = Categories::create($input);


        return $this->sendResponse(new CategorieResource($categories), 'Categoria criado com sucesso.');
    }

    public function show($id)
    {
        $categories = Categories::find($id);

        if (is_null($categories)) {
            return $this->sendError('Categoria não encontrada.');
        }

        return $this->sendResponse(new CategorieResource($categories), 'Categoria selecionado com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $input = Categories::findOrFail($id);


        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input->update($request->all());

        return $this->sendResponse(new CategorieResource($input), 'Categoria atualizado com sucesso.');
    }

    public function destroy(Categories $categories, $id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return $this->sendResponse([], 'Categoria deletado com sucesso.');
    }
}

