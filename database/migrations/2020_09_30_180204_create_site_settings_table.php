<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name',255);
            $table->string('mailing_address',500);
            $table->string('paypal_business_email',500)->nullable();
            $table->string('custom_admin_url',100);
            $table->string('site_tagline',500)->nullable();
            $table->string('address',500);
            $table->string('contact_number',50);
            $table->string('facebook_url',500)->nullable();
            $table->string('facebook_class',500)->nullable();
            $table->string('twitter_url',500)->nullable();
            $table->string('twitter_class',500)->nullable();
            $table->string('linkedin_url',500)->nullable();
            $table->string('linkedin_class',500)->nullable();
            $table->string('pintarest_url',500)->nullable();
            $table->string('pintarest_class',500)->nullable();
            $table->string('instagram_url',500)->nullable();
            $table->string('instagram_class',500)->nullable();
            $table->string('admin_login_logo',500)->nullable();
            $table->string('admin_logo',500)->nullable();
            $table->string('site_logo',500)->nullable();
            $table->string('site_footer_logo',500)->nullable();
            $table->string('favicon',500)->nullable();
            $table->string('home_page_featured_product_section_title',500)->nullable();
            $table->string('home_page_featured_product_section_description',500)->nullable();
            $table->string('home_page_testimonial_section_title',500)->nullable();
            $table->string('home_page_testimonial_section_description',500)->nullable();
            $table->string('home_page_newsletter_section_title',500)->nullable();
            $table->string('home_page_newsletter_section_description',500)->nullable();
            $table->string('home_page_forum_section_title',500)->nullable();
            $table->string('home_page_forum_section_description',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
