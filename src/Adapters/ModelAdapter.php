<?php

namespace DataTables\Adapters;

use Phalcon\Mvc\Model\Criteria;

class ModelAdapter extends \DataTables\DataTable
{
    private $model;
    private $params;

    private function search()
    {
        if (empty($this->search['value']))
        {
            foreach ($this->columns as $column){
                $criteria[$column['data']] = $column['search']['value'];
            }

            $query = Criteria::fromInput($this->di, $this->model, $criteria);
            $this->params = array_replace_recursive($this->params, (is_array($query->getParams()) ? $query->getParams() : []));
        } else {
            
        }
    }

    public function __construct($model, $params = [])
    {
        parent::__construct();

        $this->model = $model;
        $this->params = $params;

        $this->total = $model::count($this->params);
        
        $this->search();

        $this->filtered = $model::count($this->params);

        foreach($this->order as $order)
        {
            $orders[] = $this->columns[$order['column']]['data'] . ' ' . $order['dir'];
        }

        $this->params = array_replace_recursive($this->params, [
            'limit' => $this->limit,
            'offset' => $this->offset,
            'order' => join(', ', $orders)
        ]);

        $this->records = $model::find($this->params);
    }
}
