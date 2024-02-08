<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    public $request;
    protected $builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter) && $value != null) {
                $this->$filter($this->request->$value);
            }
        }
        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }

    public function setExtraFilters($extra)
    {
        return $this->request->merge($extra);
    }
}
