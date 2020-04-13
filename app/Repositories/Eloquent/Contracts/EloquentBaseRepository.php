<?php


namespace App\Repositories\Eloquent\Contracts;


use App\Repositories\Contracts\RepositoryInterface;

class EloquentBaseRepository implements RepositoryInterface
{
    protected $model;

    public function all(array $columns = null, array $relations = [])
    {
        $query = $this->model::query();
        if (!empty($relations)) {
            $query->with($relations);
        }
        if (!is_null($columns)) {
            $query->get($columns);
        }

        return $query->get();
    }

    public function paginate(int $page)
    {
        return $this->model::paginate($page);
    }

    public function find(int $ID)
    {
        return $this->model::find($ID);
    }

    public function findBy(array $criteria, array $columns = null, bool $single = true)
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }
        $method = $single ? 'first' : 'get';

        return is_null($columns) ? $query->{$method}()
            : $query->{$method}($columns);
    }

    public function store(array $item)
    {
        return $this->model::create($item);
    }

    public function update(int $ID, array $item)
    {
        $items = $this->model::find($ID);
        if ($items) {
            return $items->update($item);
        }
    }

    public function updateBy(array $criteria, array $data)
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        return $query->update($data);
    }

    public function delete(int $ID)
    {
        if (intval($ID) > 0) {
            return $this->model::destory($ID);
        }
    }

    public function deleteBy(array $criteria)
    {
        $query = $this->model::query();
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }
        $query->delete();
    }


    public function findWith(int $id, $relations = [])
    {
        if (!empty($relations)) {
            return $this->model::with($relations)
                ->where((new $this->model)->getKeyName(), $id)
                ->get();
        }
        return $this->model::find($id);
    }

    //    public function filters(QueryFilter $builder)
    //    {
    //        return $this->model::filters($builder);
    //    }
}
