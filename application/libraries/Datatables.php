<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatables {

    protected $CI;  

    protected $query;

    protected $showColumns = array();

    protected $orderableColumns = array();

    protected $addColumns = array();

    protected $editColumn = array();

    protected $searchableColumns = array();

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function collection($collection) {
        $this->query = $collection;
        return $this;
    }

    public function showColumns($columns) {
        $parse = explode(',', $columns);
        foreach ($parse as $column) {
            $this->showColumns[] = trim($column);
            $this->orderableColumns[] = trim($columns);
        }
        return $this;
    }

    public function orderableColumns($columns) {
        $this->orderableColumns = array();
        $parse = explode(',', $columns);
        foreach ($parse as $column) {
            $this->orderableColumns[] = trim($column);
        }
        return $this;
    }

    public function addColumn($name, $value) {
        $this->addColumns[$name] = $value;
        return $this;
    }

    public function editColumn($name, $value) {
        $this->editColumn[$name] = $value;
        return $this;
    }   

    public function searchableColumns($columns) {
        $parse = explode(',', $columns);
        foreach ($parse as $column) {
            $this->searchableColumns[] = trim($column);
        }       
        return $this;
    }

    public function search() {          
        $search = $this->CI->input->post('search');
        if ($search) {
            if (count($this->searchableColumns) <> 0) { 
                $this->CI->db->group_start();               
                $searchColumns = $this->searchableColumns;
                $this->CI->db->like($searchColumns[0], strtolower($search['value']), false);
                unset($searchColumns[0]);
                foreach ($searchColumns as $searchColumn) {
                    $this->CI->db->or_like($searchColumn, strtolower($search['value']), false);
                }
                $this->CI->db->group_end();
            }
        }

    }

    public function orderBy() {
        $orders = $this->CI->input->post('order');
        if ($orders) {
            foreach ($orders as $order) {
                if (isset($this->orderableColumns[$order['column']])) {
                    $column = $this->orderableColumns[$order['column']];
                    $this->CI->db->order_by($column, $order['dir']);
                }           
            }
        }
    }

    public function render($encode = false) {                
        $start = $this->CI->input->post('start');
        $length = $this->CI->input->post('length');         
        $this->CI->db->from('(' . $this->query . ') datatable');
        $recordsTotal = $this->CI->db->count_all_results();

        $this->search();
        $this->orderBy();
        $this->CI->db->from('(' . $this->query . ') datatable');
        $recordsFiltered = $this->CI->db->count_all_results();

        $this->CI->db->from('(' . $this->query . ') datatable');
        $this->search();
        $this->orderBy();
        $this->CI->db->limit($length, $start);      
        $dataSource = $this->CI->db->get(); 
		//echopre($this->CI->db->last_query());
		//exit;
        $data = array();
        foreach ($dataSource->result() as $key => $row) {  
		
            $data[$key] = array();
            if (count($this->showColumns) <> 0) {
                foreach ($this->showColumns as $column) {                   
                    if (isset($this->editColumn[$column])) {
                        if (is_callable($this->editColumn[$column])) {
                            $data[$key][$column] = $this->editColumn[$column]($row);    
                        } else {
                            $data[$key][$column] = $this->editColumn[$column];  
                        }
                    } else {
                        $data[$key][$column] = $row->$column;
                    }               
                }
            } else {
                foreach ($row as $index => $value) {
                    if (isset($this->editColumn[$index])) {
                        if (is_callable($this->editColumn[$index])) {
                            $data[$key][$index] = $this->editColumn[$index]($row);    
                        } else {
                            $data[$key][$index] = $this->editColumn[$index];  
                        }        
                    } else {
                        $data[$key][$index] = $value;
                    }
                }
            }
            foreach ($this->addColumns as $name => $addColumn) {
                if (is_callable($addColumn)) {
                    $data[$key][$name] = $addColumn($row);
                } else {
                    $data[$key][$name] = $addColumn;
                }
            }
        }
        $response = array(
            'draw'                => intval($this->CI->input->post('draw')),
            'recordsTotal'        => $recordsTotal,
            'recordsFiltered'     => $recordsFiltered,
            'data'                => $data
            );
        if ($encode) {
            return json_encode($response);
        } else {
            return $response;
        }
    }

}