<?php


namespace App\Http\Controllers\Concerns;


use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait HasCrud
{
    public function index()
    {
        return $this->response($this->model::orderBy('id', 'DESC')->get());
    }

    public function store(Request $request)
    {
        $model = new $this->model();
        $data = $request->all();
        $model->fill($data);
        $model->company_id = $request->user()->company_id;
        $model->save();
        return $this->response($model);

    }

    public function show($id)
    {
        return $this->response($this->model::find($id));
    }

    public function update(Request $request)
    {
        $model = $this->model::find($request->id);

        if (!$model)
            throw new Exception('Record not found');

        $model->fill($request->all());
        $model->save();

        return $this->response($model->refresh());

    }

    public function destroy(Request $request): JsonResponse
    {
        $model = $this->model::find($request->id);

        if (!$model)
            throw new Exception('Record not found');

        $model->delete();

        return $this->success($this->model.' deleted');
    }


    public function forceDestroy($id): JsonResponse
    {
        try{
            $model = $this->model::find($id);

            if (!$model)
                throw new Exception('Record not found');

            $model->forceDelete();

            return $this->success($this->model.' deleted');
        }catch (Exception $exception){
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function response($result)
    {
        if ($result instanceof Model){
            return $this->resource ? new $this->resource($result) : $this->success('Success', $result);
        }

        if ($result instanceof Collection){
            return $this->resource ? $this->resource::collection($result) : $this->success('Success' ,$result);
        }

        return $this->success('Success', $this->success($result));
    }
}
