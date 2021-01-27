<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip', 'host', 'description', 'avatar'];

    /**
     * Get the requests for the server model.
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
