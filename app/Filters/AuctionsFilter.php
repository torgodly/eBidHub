<?php

namespace App\Filters;

class AuctionsFilter extends Filters
{
    protected $filters = ['price', 'min_bid', 'end', 'buy_now', 'category'];

    public function price()
    {
        return $this->builder->whereHas('bids', function ($query)  {
            $query->where('amount', '<=', $this->request->price);
        })->orWhere('price', '<=', $this->request->price);
    }

    public function min_bid()
    {
        return $this->builder->where('minimum_bid', '=', $this->request->min_bid);
    }

    public function end()
    {
        return $this->builder->whereDate('end', '<=', $this->request->end);
    }

    public function buy_now($value)
    {
        return $this->builder->where('buy_now', true);
    }

    public function category()
    {
        return $this->builder->whereHas('categories', function ($query) {
            $query->where('categories.id','=', $this->request->category);
        });
    }


}
