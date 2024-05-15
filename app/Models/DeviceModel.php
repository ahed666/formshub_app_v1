<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeDevice;
class DeviceModel extends Model
{
    use HasFactory;
    protected $table="devices_models";

    public function devices()
{
    return $this->hasMany(TypeDevice::class);
}

}
