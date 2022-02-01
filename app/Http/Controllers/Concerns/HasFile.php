<?php


namespace App\Http\Controllers\Concerns;

use App\Http\Resources\AttachmentResource;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HasFile
{
    public function hasFiles(Request $request) : bool
    {
        return count($request->allFiles()) > 0;
    }

    public function saveFiles(Model $model, array $files)
    {
        try{
            $attached = [];
            foreach ($files as $file){
                /*remove existing attachments for updates */
                Attachment::where([
                    'model' => self::getModelName($model),
                    'model_id' => $model->id
                ])->delete();

                $attachment = new Attachment();
                $attachment->model = self::getModelName($model);
                $attachment->model_id = $model->id;
                $attachment->attachment = $file->getClientOriginalName();

                if (Storage::disk('public')->exists("attachments/".self::getModelName($model)."/" . $model->id . '/' . $attachment->attachment))
                    $attachment->attachment = uniqid().'.'.$file->getClientOriginalExtension();

                Storage::disk('public')->put("attachments/".self::getModelName($model)."/" . $model->id . '/' . $attachment->attachment, file_get_contents($file));
                $attachment->save();

                $attached[] = $attachment->attachment;
            }
            return count($attached) > 1 ? $attached : array_shift($attached);
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function getFiles(Model $model)
    {
        return AttachmentResource::collection(Attachment::where([
            'model' => self::getModelName($model),
            'model_id' => $model->id
        ])->get());
    }

    /**
     * @param Model $model
     * @return string
     */
    public static function getModelName(Model $model = null) : string
    {
        $class_parts = explode('\\', get_class($model ?? self::class));
        return end($class_parts);
    }
}
