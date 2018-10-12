<?php

namespace DataTables\Adapters;

class ArrayAdapter extends \DataTables\DataTable
{

    private $data;

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;

        $this->total = count($this->data);
        
        // $this->limit = $this->total < $this->limit ? $this->total : $this->offset + $this->limit;
        // $this->modelSearch();

        $this->filtered = count($this->data);

        $this->data = $this->sort($this->columns[$this->order[0]['column']]['data'], $this->order[0]['dir']);

        for ($i = $this->offset; $i < ($this->offset + $this->limit); ++$i){
            if (!isset($this->data[$i])){
                break;
            }

            $records[] = (object) $this->data[$i];
        }

        $this->records = $records;
    }

    private function sort($column, $dir)
    {
        $newArray = [];
        $sortableArray = [];

        if ($this->total > 0){
            foreach ($this->data as $k => $v){
                if (is_array($v)){
                    foreach ($v as $k2 => $v2){
                        if ($k2 == $column) {
                            $sortableArray[$k] = $v2;
                        }
                    }
                } else {
                    $sortableArray[$k] = $v;
                }
            }

            switch ($dir){
                case 'asc':
                    asort($sortableArray);
                    break;
                case 'desc':
                    arsort($sortableArray);
                    break;
            }

            foreach ($sortableArray as $k => $v){
                $newArray[] = $this->data[$k];
            }
        }

        return $newArray;
    }
}
