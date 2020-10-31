<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentBank extends Model
{
	public function directoryId()
    {
        return $this->belongsTo('App\Models\Directory','directory_id');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo('App\User','updated_by');
    }
}
