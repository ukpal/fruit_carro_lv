<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_orders';
    protected $guarded=[];
    // protected $fillable = [
    //     'user_id','shopping_full_name','shopping_email_address','shopping_contact_number', 'shopping_address_line_1','shopping_address_line_2','shopping_city','shopping_state','shopping_country','shopping_zip_code', 'billing_full_name','billing_email_address','billing_contact_number','billing_address_line_1','billing_address_line_2','billing_city', 'billing_state','billing_country','billing_zip_code', 'order_date','payment_type_id','order_status_id'
    // ];
}
