<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = [
        'prefix',
        'first_name',
        'last_name',
        'birthdate',
        'profile_image',
        'transaction_date',
        'amount',
        'transaction_type',
    ];

    // เพิ่มคอลัมน์ age ที่คำนวณอายุอัตโนมัติ
    protected $appends = ['age'];

    public function getAgeAttribute() {
        return now()->diffInYears($this->birthdate);
    }
}
