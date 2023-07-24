<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SiteSetting extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'fc_site_settings';

    public $timestamps = false;
    protected $fillable = [
        'site_name','mailing_address', 'custom_admin_url','address', 'contact_number','facebook_url','facebook_class','twitter_url','twitter_class','linkedin_url','linkedin_class','pintarest_url','pintarest_class','instagram_url','instagram_class','admin_login_logo','admin_logo','site_logo','site_footer_logo','favicon','home_page_featured_product_section_title','home_page_featured_product_section_description','home_page_testimonial_section_title','home_page_testimonial_section_description','home_page_newsletter_section_title','home_page_newsletter_section_description','home_page_forum_section_title','home_page_forum_section_description'
    ];
}
