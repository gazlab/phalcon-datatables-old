<?php

namespace DataTables\Adapters;

class ModelAdapter extends \DataTables\DataTable
{
    private $criteria;

    public function __construct($model, $params = null)
    {
        parent::__construct();

        $builder = is_string($model) ? $model::query() : $model;
        
        $this->total = count($builder->execute());
        
        if (empty($this->search['value']))
        {
            foreach ($this->columns as $column){
                if (!empty($column['search']['value'])){
                    $builder->andWhere($column['data'] . " LIKE '%" . $column['search']['value'] . "%'");
                }
            }
        } else {
            foreach ($this->columns as $column){
                $builder->orWhere($column['data'] . " LIKE '%" . $this->search['value'] . "%'");
            }
        }
        
        $this->filtered = count($builder->execute());

        $builder->limit($this->limit, $this->offset);
        $builder->orderBy($this->columns[$this->order[0]['column']]['data'] . ' ' . $this->order[0]['dir']);

        $this->records = $builder->execute();
    }
}
