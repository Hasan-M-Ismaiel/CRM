<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'VAT', 'address', 'project_id'];


    public function projects ()
    {
        return $this->hasMany(Project::class);
    }


    protected function numberOfProjects(): Attribute
    {
        $numeberOfProjects = $this->projects()->count();
        return Attribute::make(
            get: fn () => $numeberOfProjects,
        );
    }
}
