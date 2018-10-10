<?php

namespace DataTables\Adapters;

class ArrayAdapter extends \DataTables\DataTable
{

    public function __construct($data)
    {
        parent::__construct();

        $this->total = count($data);
        
        $this->limit = $this->total < $this->limit ? $this->total : $this->offset + $this->limit;
        // $this->modelSearch();

        $this->filtered = count($data);

        for ($i = $this->offset; $i < $this->limit; ++$i){
            $records[] = (object) $data[$i];
        }
        $this->records = $records;
    }
}
