<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferPersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'OFFER_PERSONALINFORMATION';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['offer_id', 'personal_id'];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'personal_id');
    }
}