<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class BaseService
{
    /**
     * @var Model|null
     */
    public $class = null;

    /**
     * BaseService constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param array $attributes
     * @param int|null $id
     * @return mixed
     */
    public function storeOrUpdate(array $attributes, int $id = null)
    {
        $model = new $this->class;
        if (!is_null($id)) {
            $model = $this->find($id);
        }

        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function filter(array $filters)
    {
        $query = ($this->class)::query();

        if ($filters['where'] ?? false) {
            foreach ($filters['where'] as $whereCondition) {
                $query->where(
                    $whereCondition['column'],
                    $whereCondition['operator'] ?? '=',
                    $whereCondition['value']
                );
            }
        }

        if ($filters['with'] ?? false) {
            $query->with($filters['with']);
        }

        if ($filters['with_scopes'] ?? false) {
            foreach ($filters['with_scopes'] as $scope) {
                if (is_array($scope)) {
                    call_user_func_array([$query, $scope['method']], $scope['params']);
                } else {
                    $query->{$scope}();
                }
            }
        }

        if ($filters['with_count'] ?? false) {
            $query->withCount($filters['with_count']);
        }

        if ($filters['order_by'] ?? false) {
            $query->orderBy($filters['order_by']['column'], $filters['order_by']['direction'] ?? 'ASC');
        }

        if ($filters['limit'] ?? false) {
            $query->limit($filters['limit']);
        }

        if ($filters['id'] ?? false) {
            return $query->find($filters['id']);
        }

        return $query->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $query = ($this->class)::query();
        if (in_array(SoftDeletes::class, class_uses_recursive($this->class))) {
            $query->withTrashed();
        }

        return $query->findOrFail($id);
    }

    /**
     * @param int $id
     * @param array $relationships
     * @return mixed
     */
    public function findWith(int $id, array $relationships)
    {
        $query = ($this->class)::query();
        if (in_array(SoftDeletes::class, class_uses_recursive($this->class))) {
            $query->withTrashed();
        }

        return $query->with($relationships)
            ->findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        $query = ($this->class)::query();
        if (in_array(SoftDeletes::class, class_uses_recursive($this->class))) {
            $query->withTrashed();
        }

        return $query->orderBy('updated_at', 'ASC')->get();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function paginate()
    {
        return DataTables::of(($this->class)::query())->make(true);
    }

    /**
     * @param array $relationships
     * @return Collection
     *
     */
    public function allWith(array $relationships): Collection
    {
        return ($this->class)::withTrashed()
            ->with($relationships)
            ->orderBy('updated_at', 'DESC')
            ->get();
    }

    /**
     * @param int $id
     */
    public function restore(int $id): void
    {
        if (in_array(SoftDeletes::class, class_uses_recursive($this->class))) {
            $model = $this->find($id);
            if ($model->trashed()) {
                $model->restore();
            }
        }

    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $model = $this->find($id);
        if (in_array(SoftDeletes::class, class_uses_recursive($this->class)) && $model->trashed()) {
            $model->forceDelete();
        } else {
            $model->delete();
        }

        return $model;
    }
}
