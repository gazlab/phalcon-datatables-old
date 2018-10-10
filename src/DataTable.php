<?php

namespace DataTables;

class DataTable extends \Phalcon\Mvc\User\Plugin
{
    public $limit;
    public $offset;
    public $order;
    public $search;
    public $columns;

    public $records;
    public $total;
    public $filtered;

    public function __construct()
    {
        $this->limit = (int) $this->request->get('length');
        $this->offset = (int) $this->request->get('start');
        $this->order = $this->request->get('order');
        $this->search = $this->request->get('search');
        $this->columns = $this->request->get('columns');
    }

    public static function array($data)
    {
        return new Adapters\ArrayAdapter($data);
    }

    public static function model($model, $params = [])
    {
        return new Adapters\ModelAdapter($model, $params);
    }

    public function send()
    {
        $this->view->disable();

        $response['draw'] = (int) $this->request->get('draw');
        $response['recordsTotal'] = $this->total;
        $response['recordsFiltered'] = $this->filtered;
        $response['data'] = [];

        foreach ($this->records as $record){
            foreach ($this->columns as $column){
                $field = $column['data'];
                $columns[$field] = $record->$field;
            }

            $response['data'][] = $columns;
        }

        $this->response->setContentType('application/json');
        $this->response->setJsonContent($response);
        $this->response->send();
    }
}
