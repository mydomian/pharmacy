<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = ['customer_id','sale_id','total','paid','due','payment_date','payment_status','note'];
}

