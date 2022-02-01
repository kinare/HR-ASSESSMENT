<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasRelations
{
    public function getRelations($model): array
    {
        $reflector = new \ReflectionClass($model);

        $relationships = [];

        foreach($reflector->getMethods() as $method){
            $returnType = $method->getReturnType();

            if ($returnType)
                switch (class_basename($returnType->getName())){
                    case 'HasOne':
                        $relationships['child'][] = $method->getName();
                        break;
                    case 'HasMany';
                        $relationships['children'][] = $method->getName();
                        break;
                    case 'BelongsTo';
                        $relationships['parent'][] = $method->getName();
                        break;
                    case 'BelongsToMany';
                        $relationships['parents'][] = $method->getName();
                        break;
                }
        }

        return $relationships;
    }

    public function getRelatedModels(Builder $model, array $params): Builder
    {
        $relations = $this->getRelations($this->model);
        foreach ($relations as $key => $value){
            if (array_key_exists($key, $params)){

                if ($params[$key] === '*')
                    $model->with($value);

                foreach (explode(',', $params[$key]) as $item){
                    if (in_array($item, $value))
                        $model->with($item);
                }
            }
        }

        return $model;
    }

    public function filterModel(string $filter, Builder $model): Builder
    {
        $filters = rtrim(ltrim($filter, '('), ')');
        $filters = explode(',', $filters );

        $filter = [];
        foreach ($filters as $item){
            $f = explode('=', $item);
            $filter[trim(array_shift($f))] = trim(array_pop($f));
        }

        return $model->where($filter);
    }
}
