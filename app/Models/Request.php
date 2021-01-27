<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['process', 'session'];

    /**
     * Get the server that owns the request.
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
