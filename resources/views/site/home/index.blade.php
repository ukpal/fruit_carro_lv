@extends('layouts.site')

@section('content')

<!--Three Cols-->
<section id="three_feature" class="padding_half">
  <h3 class="hidden">hiddden</h3>
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="box margin40">
          <div class="image">
            <img src="{{ URL::asset('public/assets/site/images/home4-box1.jpg') }}" alt="box">
          </div>
          <a class="panel_bottom" href="#.">Buying Your Home</a>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="box margin40">
          <div class="image">
            <img src="{{ URL::asset('public/assets/site/images/home-box2.jpg') }}" alt="box">
          </div>
          <a class="panel_bottom" href="#.">Buying Your Home</a>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="box margin40">
          <div class="image">
            <img src="{{ URL::asset('public/assets/site/images/home-box3.jpg') }}" alt="box">
          </div>
          <a class="panel_bottom" href="#.">Buying Your Home</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Three Cols Ends-->

<!--Advance Search-->
<section class="property-query-area padding_bottom">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h2 class="uppercase">Advanced Search</h2>
        <p class="heading_space">We have Properties in these Areas View a list of Featured Properties.</p>
      </div>
    </div>
    <div class="row">
      <form class="callus">
        <div class="col-md-3 col-sm-6">
          <div class="single-query form-group">
            <input type="text" class="keyword-input" placeholder="Keyword (e.g. 'office')">
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="single-query form-group">
            <div class="intro">
              <select>
                <option selected="" value="any">Location</option>
                <option>All areas</option>
                <option>Bayonne </option>
                <option>Greenville</option>
                <option>Manhattan</option>
                <option>Queens</option>
                <option>The Heights</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="single-query form-group">
            <div class="intro">
              <select>
                <option class="active">Property Type</option>
                <option>All areas</option>
                <option>Bayonne </option>
                <option>Greenville</option>
                <option>Manhattan</option>
                <option>Queens</option>
                <option>The Heights</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="single-query form-group">
            <div class="intro">
              <select>
                <option class="active">Property Status</option>
                <option>All areas</option>
                <option>Bayonne </option>
                <option>Greenville</option>
                <option>Manhattan</option>
                <option>Queens</option>
                <option>The Heights</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="row search-2">
            <div class="col-md-6 col-sm-6">
              <div class="single-query form-group">
                <div class="intro">
                  <select>
                    <option class="active">Min Beds</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="single-query form-group">
                <div class="intro">
                  <select>
                    <option class="active">Min Baths</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="row">
            <div class="col-sm-6">
              <div class="single-query form-group">
                <input type="text" class="keyword-input" placeholder="Min Area (sq ft)">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="single-query form-group">
                <input type="text" class="keyword-input" placeholder="Max Area (sq ft)">
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-8">
              <div class="single-query-slider">
                <label>Price Range:</label>
                <div class="price text-right">
                  <span>$</span>
                  <div class="leftLabel"></div>
                  <span>to $</span>
                  <div class="rightLabel"></div>
                </div>
                <div data-range_min="0" data-range_max="1500000" data-cur_min="0" data-cur_max="1500000" class="nstSlider">
                  <div class="bar"></div>
                  <div class="leftGrip"></div>
                  <div class="rightGrip"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-right form-group">
              <button type="submit" class="btn-blue border_radius top15">Search</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="group-button-search">
      <a data-toggle="collapse" href=".search-propertie-filters" class="more-filter">
        <i class="fa fa-plus text-1" aria-hidden="true"></i><i class="fa fa-minus text-2 hide" aria-hidden="true"></i>
        <div class="text-1">Show more search options</div>
        <div class="text-2 hide">less more search options</div>
      </a>
    </div>
    <div class="search-propertie-filters collapse">
      <div class="container-2">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
          <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="search-form-group white">
              <input type="checkbox" name="check-box" />
              <span>Rap music</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Advance Search Ends-->

<!-- Property listing -->
<section id="property" class="padding index2 bg_light">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="uppercase">PROPERTY LISTINGS</h2>
        <p class="heading_space"> We are proud to present to you some of the best homes, apartments, offices e.g. across Australia for affordable prices. </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing1.jpg') }}" alt="latest property" class="img-responsive"></a>
            <div class="price clearfix"> 
              <span class="tag pull-right">For Rent</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>2 Office Rooms</span> 
              <span><i class="icon-safety-shower"></i>1 Bathroom</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy 
                nibh tempor cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$8,600 Per Month</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#one" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="one">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head default_clr text-center">
            <img src="{{ URL::asset('public/assets/site/images/favruite.png') }}" alt="property" class="start_tag">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"> <img src="{{ URL::asset('public/assets/site/images/listing2.jpg') }}" alt="latest property" class="img-responsive"></a>
            <div class="price clearfix"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span> 
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh tempor 
                cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$8,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#two" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="two">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing3.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag pull-left">For Rent</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span>
              <span><i class="icon-bed"></i>2 Office</span> 
              <span><i class="icon-safety-shower"></i>2 Bathroom</span> 
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh tempor 
                cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$8,600 Per Month</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#three" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="three">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head default_clr text-center">
            <img src="{{ URL::asset('public/assets/site/images/favruite.png') }}" alt="property" class="start_tag">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing4.jpg') }}" alt="latest property" class="img-responsive"></a>
            <div class="price"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bathroom</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh tempor 
                cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$8,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#four" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="four">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing5.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag">For Rent</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh tempor 
                cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$82,600 Per Month</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#five" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="five">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing6.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
                tempor cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$82,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#six" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="six">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing7.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
                tempor cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$82,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#seven" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="seven">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing8.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
                tempor cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$82,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#eight" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="eight">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="property_item heading_space">
          <div class="property_head text-center">
            <h3 class="captlize">Historic Town House</h3>
            <p>45 Regent Street, London, UK</p>
          </div>
          <div class="image">
            <a href="javascript:void(0)"><img src="{{ URL::asset('public/assets/site/images/listing9.jpg') }}" alt="latest property" class="img-responsive"></a> 
            <div class="price"> 
              <span class="tag">For Sale</span>
            </div>
          </div>
          <div class="proerty_content">
            <div class="property_meta"> 
              <span><i class="icon-select-an-objecto-tool"></i>4800 sq ft</span> 
              <span><i class="icon-bed"></i>3 Bedrooms</span> 
              <span><i class="icon-safety-shower"></i>2 Bedrooms</span>   
            </div>
            <div class="proerty_text">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy 
                nibh tempor cum soluta nobis…
              </p>
            </div>
            <div class="favroute clearfix">
              <p class="pull-md-left">$82,600</p>
              <ul class="pull-right">
                <li><a href="javascript:void(0)"><i class="icon-like"></i></a></li>
                <li><a href="#nine" class="share_expender" data-toggle="collapse"><i class="icon-share3"></i></a></li>
              </ul>
            </div>
            <div class="toggle_share collapse" id="nine">
              <ul>
                <li><a href="javascript:void(0)" class="facebook"><i class="icon-facebook-1"></i> Facebook</a></li>
                <li><a href="javascript:void(0)" class="twitter"><i class="icon-twitter-1"></i> Twitter</a></li>
                <li><a href="javascript:void(0)" class="vimo"><i class="icon-vimeo3"></i> Vimeo</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <ul class="pager">
          <li><a href="#.">1</a></li>
          <li class="active"><a href="#.">2</a></li>
          <li><a href="#.">3</a></li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- Property listing Ends -->



<!--Testinomials-->
<section id="testinomial" class="padding">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 text-center">
        <h2 class="uppercase">Happy Customers</h2>
        <p class="heading_space">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam nec viverra erat Aenean elit tellus.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="testinomial-slider" class="owl-carousel">
          <div class="item">
            <div class="testinomial_content text-center">
              <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="happy client" class="bottom15">
              <h4 class="uppercase"> SAM NICHOLSON</h4>
              <span class="smmery bottom15">( NorthMarq Capital  )</span>
              <img src="{{ URL::asset('public/assets/site/images/stars.png') }}" alt="rating" class="bottom30">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh tempor cum soluta nobis consectetuer adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel.</p>
            </div>
          </div>
          <div class="item">
            <div class="testinomial_content text-center">
              <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="happy client" class="bottom15">
              <h4 class="uppercase"> SAM NICHOLSON</h4>
              <span class="smmery bottom15">( NorthMarq Capital  )</span>
              <img src="{{ URL::asset('public/assets/site/images/stars.png') }}" alt="rating" class="bottom30">
              <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh tempor cum soluta nobis consectetuer adipiscing. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 text-center">
      <a href="javascript:void(0)" class="cd-see-all btn-white border_radius margin40"><i class="fa fa-th" aria-hidden="true"></i>view all</a>
    </div>
  </div>
</section>
<div class="cd-testimonials-all">
  <div class="cd-testimonials-all-wrapper">
    <ul>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit totam saepe iste maiores neque animi molestias nihil illum nisi temporibus.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nostrum nisi, doloremque error hic nam nemo doloribus porro impedit perferendis. Tempora, distinctio hic suscipit. At ullam eaque atque recusandae modi fugiat voluptatem laborum laboriosam rerum, consequatur reprehenderit omnis, enim pariatur nam, quidem, quas vel reiciendis aspernatur consequuntur. Commodi quasi enim, nisi alias fugit architecto, doloremque, eligendi quam autem exercitationem consectetur.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem quibusdam eveniet, molestiae laborum voluptatibus minima hic quasi accusamus ut facere, eius expedita, voluptatem? Repellat incidunt veniam quaerat, qui laboriosam dicta. Quidem ducimus laudantium dolorum enim qui at ipsum, a error.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero voluptates officiis tempore quae officia! Beatae quia deleniti cum corporis eos perferendis libero reiciendis nemo iusto accusamus, debitis tempora voluptas praesentium repudiandae laboriosam excepturi laborum, nisi optio repellat explicabo, incidunt ex numquam. Ullam perferendis officiis harum doloribus quae corrupti minima quia, aliquam nostrum expedita pariatur maxime repellat, voluptas sunt unde, inventore.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit totam saepe iste maiores neque animi molestias nihil illum nisi temporibus.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis quia quas, quis illo adipisci voluptate ex harum iste commodi nulla dolor. Eius ratione quod ab!</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, dignissimos iure rem fugiat consequuntur officiis.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At temporibus tempora necessitatibus reiciendis provident deserunt maxime sit id. Dicta aut voluptatibus placeat quibusdam vel, dolore.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis iusto sapiente, excepturi velit, beatae possimus est tenetur cumque fugit tempore dolore fugiat! Recusandae, vel suscipit? Perspiciatis non similique sint suscipit officia illo, accusamus dolorum, voluptate vitae quia ea amet optio magni voluptatem nemo, natus nihil.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor quasi officiis pariatur, fugit minus omnis animi ut assumenda quod commodi, ad a alias maxime unde suscipit magnam, voluptas laboriosam ipsam quibusdam quidem, dolorem deleniti id.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At temporibus tempora necessitatibus reiciendis provident deserunt maxime sit id. Dicta aut voluptatibus placeat quibusdam vel, dolore.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
      <li class="cd-testimonials-item">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque tempore ipsam, eos suscipit nostrum molestias reprehenderit, rerum amet cum similique a, ipsum soluta delectus explicabo nihil repellat incidunt! Minima magni possimus mollitia deserunt facere, tempore earum modi, ea ipsa dicta temporibus suscipit quidem ut quibusdam vero voluptatibus nostrum excepturi explicabo nulla harum, molestiae alias. Ab, quidem rem fugit delectus quod.</p>
        <div class="cd-author">
          <img src="{{ URL::asset('public/assets/site/images/author.png') }}" alt="Author image">
          <ul class="cd-author-info">
            <li>SAM NICHOLSON</li>
            <li>CEO, CompanyName</li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
  <!-- cd-testimonials-all-wrapper -->
  <a href="javascript:void(0)" class="close-btn">Close</a>
</div>
<!--Testinomials Ends-->



<!--Agents-->
<section id="layouts" class="padding_top">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 margin_bottom">
        <h2 class="uppercase">Latest news</h2>
        <p class="heading_space">We have Properties in these Areas View a list of Featured Properties.</p>
        <div class="media news_media">
          <div class="media-left">
            <a href="javascript:void(0)">
            <img class="media-object border_radius" src="{{ URL::asset('public/assets/site/images/news1.jpg') }}" alt="Latest news">
            </a>
          </div>
          <div class="media-body">
            <h3><a href="javascript:void(0)">Historic Town House</a></h3>
            <span class="bottom15"><i class="icon-clock4"></i>Feb 22, 2017</span>
            <p class="bottom15">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
              tempor cum soluta nobis eleifend...
            </p>
            <a href="javascript:void(0)" class="btn-more">
            <i><img src="{{ URL::asset('public/assets/site/images/arrowl.png') }}" alt="arrow"></i>
            <span>Contact Me</span>
            <i><img src="{{ URL::asset('public/assets/site/images/arrowr.png') }}" alt="arrow"></i>
            </a>
          </div>
        </div>
        <div class="media news_media">
          <div class="media-left">
            <a href="javascript:void(0)">
            <img class="media-object border_radius" src="{{ URL::asset('public/assets/site/images/news2.jpg') }}" alt="Latest news">
            </a>
          </div>
          <div class="media-body">
            <h3><a href="#.">Historic Town House</a></h3>
            <span class="bottom15"><i class="icon-clock4"></i>Feb 22, 2017</span>
            <p class="bottom15">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
              tempor cum soluta nobis eleifend...
            </p>
            <a href="javascript:void(0)" class="btn-more">
            <i><img src="{{ URL::asset('public/assets/site/images/arrowl.png') }}" alt="arrow"></i>
            <span>Contact Me</span>
            <i><img src="{{ URL::asset('public/assets/site/images/arrowr.png') }}" alt="arrow"></i>
            </a>
          </div>
        </div>
        <div class="media news_media">
          <div class="media-left">
            <a href="javascript:void(0)">
            <img class="media-object border_radius" src="{{ URL::asset('public/assets/site/images/news3.jpg') }}" alt="Latest news">
            </a>
          </div>
          <div class="media-body">
            <h3><a href="#.">Historic Town House</a></h3>
            <span class="bottom15"><i class="icon-clock4"></i>Feb 22, 2017</span>
            <p class="bottom15">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam power nonummy nibh 
              tempor cum soluta nobis eleifend...
            </p>
            <a href="javascript:void(0)" class="btn-more">
            <i><img src="{{ URL::asset('public/assets/site/images/arrowl.png') }}" alt="arrow"></i>
            <span>Contact Me</span>
            <i><img src="{{ URL::asset('public/assets/site/images/arrowr.png') }}" alt="arrow"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-sm-4 margin_bottom">
        <h2 class="uppercase"> Our Agents</h2>
        <p class="heading_space">We have Properties in these Areas.</p>
        <div id="agent-slider" class="owl-carousel">
          <div class="item">
            <div class="image bottom15">
              <img src="{{ URL::asset('public/assets/site/images/agent-slider1.jpg') }}" alt="Our Agents" class="border_radius">
            </div>
            <div class="item-bottom">
              <div class="row">
                <div class="col-sm-5 bottom15">
                  <h3>Jill Warren</h3>
                  <small>sales executive</small>
                </div>
                <div class="col-sm-7 bottom15">
                  <a href="#."><i class="icon-icons142"></i> jill@castle.com</a>
                </div>
              </div>
              <p class="bottom15">orem ipsum dolor sit amet, consectetuer adipiscing tempor cum soluta nobis eleifend...</p>
              <a class="uppercase btn-blue border_radius" href="#.">Contact me</a>
            </div>
          </div>
          <div class="item">
            <div class="image bottom15">
              <img src="{{ URL::asset('public/assets/site/images/agent-slider1.jpg') }}" alt="Our Agents" class="border_radius">
            </div>
            <div class="item-bottom">
              <div class="row">
                <div class="col-sm-5 bottom15">
                  <h3>Jill Warren</h3>
                  <small>sales executive</small>
                </div>
                <div class="col-sm-7 bottom15">
                  <a href="#."><i class="icon-icons142"></i>jill@castle.com</a>
                </div>
              </div>
              <p class="bottom15">orem ipsum dolor sit amet, consectetuer adipiscing tempor cum soluta nobis eleifend...</p>
              <a class="uppercase btn-blue border_radius" href="#.">Contact me</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="border-bottom:1px solid #d3d8dd;"></div>
  </div>
</section>
<!--Agents Ends-->



<!--Partners-->
<section id="logos">
  <div class="container partner2 padding">
    <div class="row">
      <div class="col-sm-10">
        <h2 class="uppercase">Our Partners</h2>
        <p class="heading_space">Aliquam nec viverra erat. Aenean elit tellus mattis quis maximus.</p>
      </div>
    </div>
    <div class="row">
      <div id="partner-slider" class="owl-carousel">
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo1.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo2.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo3.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo4.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo5.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo1.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo2.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo3.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo4.png') }}" alt="Featured Partner">
        </div>
        <div class="item">
          <img src="{{ URL::asset('public/assets/site/images/logo5.png') }}" alt="Featured Partner">
        </div>
      </div>
    </div>
  </div>
</section>
<!--Partners Ends-->
@endsection