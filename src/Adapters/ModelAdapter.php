<?php

namespace DataTables\Adapters;

class ModelAdapter extends \DataTables\DataTable
{
    
    public function __construct($model)
    {
        parent::__construct();

        $builder = is_string($model) ? $model::query() : $model;
        
        $model = $builder->getModelName(); 

        $this->total = $model::count($builder->getParams());
        
        if (empty($this->search['value']))
        {
            foreach ($this->columns as $column){
                if (!strpos($column['data'], '.')){
                    if (isset($column['searchable']) && $column['searchable']  === 'false') {
                        continue;
                    }
                    if (!empty($column['search']['value'])){
                        $builder->andWhere($column['data'] . " LIKE '%" . $column['search']['value'] . "%'");
                    }
                }
            }  
        } else {
            foreach ($this->columns as $column){
                if (!strpos($column['data'], '.')){
                    if (isset($column['searchable']) && $column['searchable']  === 'false') {
                        continue;
                    }
                    $builder->orWhere($column['data'] . " LIKE '%" . $this->search['value'] . "%'");
                }
            }
        }
        
        $this->filtered = $model::count($builder->getParams());

        $builder->limit($this->limit, $this->offset);
        $builder->orderBy($this->columns[$this->order[0]['column']]['data'] . ' ' . $this->order[0]['dir']);

        $this->records = $builder->execute();
    }
}
