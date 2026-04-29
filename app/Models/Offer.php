<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'OFFER';
    protected $primaryKey = 'offer_id';
    public $timestamps = false;
    protected $fillable = ['offer_name', 'description', 'discount', 'start_date', 'end_date'];

    public function customers()
    {
        return $this->belongsToMany(PersonalInformation::class, 'OFFER_PERSONALINFORMATION', 'offer_id', 'personal_id');
    }
}
