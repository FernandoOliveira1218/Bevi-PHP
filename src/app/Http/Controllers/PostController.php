<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    public function __construct(Post $model) {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {//
        $modelRepository = new PostRepository($this->model);

        $modelRepository->selectAtributosRegistrosRelacionados($request->has('atributos_user') ? 'user:id,'.$request->atributos_user : 'user');

        if($request->has('filtro')) {
            $modelRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $modelRepository->selectAtributos($request->atributos);
        } 

        return response()->json($modelRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->model->rules(), $this->model->feedback());

        $this->model->fill($request->all());
        $this->model->save();

        return response()->json($this->model, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $modelRepository = new PostRepository($this->model);

        $modelRepository->selectAtributosRegistrosRelacionados($request->has('atributos_user') ? 'user:id,'.$request->atributos_user : 'user');

        if($request->has('filtro')) {
            $modelRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $modelRepository->selectAtributos($request->atributos);
        } 

        $model = $modelRepository->model->find($id);

        if($model === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        } 

        return response()->json($model, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = $this->model->find($id);

        if ($model === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }

        if ($request->method() === 'PATCH') {

            $regrasDinamicas = array();
            foreach ($model->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $model->feedback());
        } else {
            $request->validate($model->rules(), $model->feedback());
        }

        $model->fill($request->all());
        $model->update();

        return response()->json($model, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model->find($id);

        if($model === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $model->delete();
        return response()->json(['msg' => 'O post foi removida com sucesso!'], 200);
    }
}
