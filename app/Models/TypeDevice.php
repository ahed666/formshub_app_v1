<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeviceModel;
class TypeDevice extends Model
{
    use HasFactory;
    protected $table="type_of_devices";
    protected $fillable = ['model_id', 'image', 'price_prev','price','name'];

    public function model()
    {
        return $this->belongsTo(DeviceModel::class);
    }
}
