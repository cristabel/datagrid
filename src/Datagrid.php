<?php namespace Cristabel\Datagrid;

class Datagrid {
    
    protected $config;
    
    protected $model;

    protected $columns;

    protected $headers;

	protected $data;
    
    protected $toolbar;
    
    protected $buttons;

	protected $pagination;

	public function make($model, $config)
	{
		$this->model = $model;
        $this->config = $config;
        $this->select = isset($config['select']) ? $config['select'] : [];
        $this->toolbar = isset($config['toolbar']) ? $config['toolbar'] : [];
        $this->buttons = isset($config['buttons']) ? $config['buttons'] : [];

        $this->preparaDataGrid();
        
        return $this;
	}

	public function headers()
	{
		return $this->headers;
	}

	public function data()
	{
		return $this->data;
	}
    
    public function columns()
    {
        return $this->columns;
    }

    public function hasToolbar()
    {
        return count($this->toolbar) > 0 ? true : false;
    }
    
    public function toolbar()
    {
        return $this->toolbar;
    }
    
    public function buttons()
    {
        return $this->buttons;
    }
    
	public function pagination()
	{
		return $this->data;
	}
    
    public function renderColumn($row, $column)
    {
        $output = null;
        if( is_array($column) ) {
            if( isset($column['relationship']) ) {
                $output = $row->{$column['relationship']}->$column['column'];
            }
        } else {
            if( is_object($column) && is_callable($column) ) {
                $output = $column($row);
            } else {
                $output = $row->{$column};
            }
        }
        
        return $output;
    }    

    protected function preparaDataGrid()
    {
		$this->headers = [];
        $this->columns = [];
		foreach( $this->select as $key => $select ) {
            $this->headers[] = $this->prepareHeader($key, $select);
            $this->columns[] = $this->prepareColumn($key, $select);
		}
        
        $this->prepareData();
    }
    
	protected function prepareHeader($key, $select)
	{
        $header = $select;
        if( is_array($select) ) {
            $header = $key;
            if( isset($select['title']) ) {
                $header = $select['title'];
            }
            if( isset($select['relationship']) ) {
                $header = $select['title'];
            }
        }

        return $header;
	}
    
	protected function prepareColumn($key, $select)
	{
        $column = $select;
        if( is_array($select) ) {
            $column = $key;
            if( isset($select['title']) ) {
                $column = $key;
            }
            if( isset($select['relationship']) ) {
                $column = [
                    'relationship' => $key,
                    'column' => $select['relationship']['column']
                ];
            }
            if( isset($select['render']) ) {
                $column = $select['render'];
            }
        }
        
        return $column;
	}
    
    protected function prepareData()
    {
        $this->data = $this->model->get();
    }
}
