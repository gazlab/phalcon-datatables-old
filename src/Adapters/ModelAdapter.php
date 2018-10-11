<?php

namespace DataTables\Adapters;

use Phalcon\Mvc\Model\Criteria;

class ModelAdapter extends \DataTables\DataTable
{
    private $criteria;

    public function __construct($model, $criteria = null)
    {
        parent::__construct();

        $this->criteria = !is_null($criteria) ? $criteria : new Criteria();
        $this->criteria->setModelName($model);

        $this->total = $model::count($this->criteria->getParams());
        
        if (empty($this->search['value']))
        {
            foreach ($this->columns as $column){
                if (!empty($column['search']['value'])){
                    $this->criteria->andWhere($column['search']['data'] . " LIKE '%" . $column['search']['value'] . "%'");
                }
            }
        } else {
            foreach ($this->columns as $column){
                $this->criteria->orWhere($column['search']['data'] . " LIKE '%" . $this->search['value'] . "%'");
            }
        }

        $this->filtered = $model::count($this->criteria->getParams());

        $this->criteria->limit($this->limit, $this->offset);
        $this->criteria->orderBy($this->order[0]['column'], $this->order[0]['dir']);

        $this->records = $model::find($this->params);
    }
}
