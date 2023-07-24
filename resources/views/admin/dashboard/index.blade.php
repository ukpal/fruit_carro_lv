@extends('layouts.admin')

@section('content')
<!-- Row start -->
<div class="row gutters">
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="info-stats2">
      <div class="info-icon info">
        <i class="icon-eye1"></i>
      </div>
      <div class="sale-num">
        <h3>32,589</h3>
        <p>Visitors</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="info-stats2">
      <div class="info-icon danger">
        <i class="icon-shopping-cart1"></i>
      </div>
      <div class="sale-num">
        <h3>27,837</h3>
        <p>Orders</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="info-stats2">
      <div class="info-icon warning">
        <i class="icon-shopping-bag1"></i>
      </div>
      <div class="sale-num">
        <h3>43,456</h3>
        <p>Sales</p>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="info-stats2">
      <div class="info-icon success">
        <i class="icon-activity"></i>
      </div>
      <div class="sale-num">
        <h3>29,425</h3>
        <p>Expenses</p>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->

<!-- Row start -->
<div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Revenue</div>
      </div>
      <div class="card-body">

        <!-- Row start -->
        <div class="row gutters align-items-center">
          <div class="col-xl-2 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="monthly-avg">
              <h5>Weekly</h5>
              <div class="avg-block">
                <h3 class="avg-total text-success">25k</h3>
                <h6 class="avg-label">Sales</h6>
              </div>
              <div class="avg-block">
                <h3 class="avg-total text-info">67k</h3>
                <h6 class="avg-label">Revenue</h6>
              </div>
            </div>
          </div>
          <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12">
            <div id="lineRevenueGraph"></div>
          </div>
          <div class="col-xl-2 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="monthly-avg">
              <h5>Monthly</h5>
              <div class="avg-block">
                <h3 class="avg-total text-success">31k</h3>
                <h6 class="avg-label">Sales</h6>
              </div>
              <div class="avg-block">
                <h3 class="avg-total text-info">82M</h3>
                <h6 class="avg-label">Revenue</h6>
              </div>
            </div>
          </div>
        </div>
        <!-- Row end -->

      </div>
    </div>
  </div>
</div>
<!-- Row end -->

<!-- Row start -->
<div class="row gutters">
  <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Team Activity</div>
      </div>
      <div class="card-body">
        <ul class="team-activity">
          <li class="product-list clearfix">
            <div class="product-time">
              <p class="date center-text">02:30 pm</p>
              <span class="badge badge-info">New</span>
            </div>
            <div class="product-info">
              <div class="activity">
                <h6>Smart - Admin Dashboard</h6>
                <p>by Luke Etheridge</p>
              </div>
              <div class="status">
                <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="49" aria-valuemin="0" aria-valuemax="100" style="width: 49%">
                    <span class="sr-only">49% Complete (success)</span>
                  </div>
                </div>
                <p>(225 of 700gb)</p>
              </div>
            </div>
          </li>
          <li class="product-list clearfix">
            <div class="product-time">
              <p class="date center-text">11:30 am</p>
              <span class="badge badge-info">Task</span>
            </div>
            <div class="product-info">
              <div class="activity">
                <h6>User_Profile.php</h6>
                <p>by Rovane Durso</p>	
              </div>
              <div class="status">
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                    <span class="sr-only">75% Complete (success)</span>
                  </div>
                </div>
                <p>(485 of 850gb)</p>
              </div>
            </div>
          </li>
          <li class="product-list clearfix">
            <div class="product-time">
              <p class="date center-text">12:50 pm</p>
              <span class="badge badge-success">Closed</span>
            </div>
            <div class="product-info">
              <div class="activity">
                <h6>Material Design Kit</h6>
                <p>by Cosmin Capitanu</p>
              </div>
              <div class="status">
                <span class="line-seven">5,3,9,6,5,9,7,3,5,7</span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Tasks</div>
      </div>
      <div class="card-body pt-0">
        <div id="radialTasks"></div>
        <ul class="task-list-container">
          <li class="task-list-item">
            <div class="task-icon bg-info">
              <i class="icon-clipboard"></i>
            </div>
            <div class="task-info">
              <h6 class="task-title">New</h6>
              <p class="amount-spend text-info">12</p>
            </div>
          </li>
          <li class="task-list-item">
            <div class="task-icon bg-success">
              <i class="icon-clipboard"></i>
            </div>
            <div class="task-info">
              <h6 class="task-title">Done</h6>
              <p class="amount-spend text-success">15</p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->

<!-- Row start -->
<div class="row gutters">
  <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="daily-goal-container">
        <div class="goal-info">
          <h4>Today's Goal</h4>
          <h6 class="text-success">70/100</h6>
        </div>
        <div class="goal-graph">
          <div id="todaysTarget"></div>
          <div class="circle-one"></div>
          <div class="circle-two"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="new-customers-card">
        <h6>New Customers</h6>
        <h4>2579</h4>
        <div class="new-customers-graph" id="lineNewCustomersGraph"></div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
    <div class="card">
      <div class="payments-card">
        <h6>Balance</h6>
        <h4>$5699.89</h4>
        <div class="custom-btn-group mt-2">
          <button class="btn btn-success"><i class="icon-credit-card"></i>Add Funds</button>
          <button class="btn btn-danger"><i class="icon-credit-card"></i>Withdraw</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->

<!-- Row start -->
<div class="row gutters">
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Statistics</div>
      </div>
      <div class="card-body">
        <div class="customScroll5">
          <ul class="statistics">
            <li>
              <span class="stat-icon bg-info">
                <i class="icon-eye1"></i>
              </span>
              A new ticket opened.
            </li>
            <li>
              <span class="stat-icon bg-danger">
                <i class="icon-thumbs-up1"></i>
              </span>
              That's A great idea!
            </li>
            <li>
              <span class="stat-icon bg-warning">
                <i class="icon-star2"></i>
              </span>
              Tell us what you think.
            </li>
            <li>
              <span class="stat-icon bg-success">
                <i class="icon-shopping-bag1"></i>
              </span>
              A new item sold.
            </li>
            <li>
              <span class="stat-icon bg-info">
                <i class="icon-check-circle"></i>
              </span>
              Design approved.
            </li>
            <li>
              <span class="stat-icon bg-danger">
                <i class="icon-clipboard"></i>
              </span>
              Assigned new task to Zyan.
            </li>
            <li>
              <span class="stat-icon bg-warning">
                <i class="icon-eye1"></i>
              </span>
              A new ticket opened.
            </li>
            <li>
              <span class="stat-icon bg-success">
                <i class="icon-thumbs-up1"></i>
              </span>
              That's A great idea!
            </li>
            <li>
              <span class="stat-icon bg-info">
                <i class="icon-star2"></i>
              </span>
              Tell us what you think.
            </li>
            <li>
              <span class="stat-icon bg-danger">
                <i class="icon-shopping-bag1"></i>
              </span>
              A new item sold.
            </li>
            <li>
              <span class="stat-icon bg-warning">
                <i class="icon-check-circle"></i>
              </span>
              Design approved.
            </li>
            <li>
              <span class="stat-icon bg-success">
                <i class="icon-clipboard"></i>
              </span>
              Assigned new task to Zyan.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Activity</div>
      </div>
      <div class="card-body">
        <div class="customScroll5">
          <div class="timeline-activity">
            <div class="activity-log">
              <p class="log-name">Corey Haggard<small class="log-time">- 9 mins ago</small></p>
              <div class="log-details">Tycoon dashboard has been created<span class="text-success ml-1">#New</span></div>
            </div>
            <div class="activity-log">
              <p class="log-name">Gleb Kuznetsov<small class="log-time">- 4 hrs ago</small></p>
              <div class="log-details">
                Farewell day photos uploaded.
                <div class="stacked-images mt-1">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user.png') }}" alt="Profile Image">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user2.png') }}" alt="Profile Image">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user3.png') }}" alt="Profile Image">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user4.png') }}" alt="Profile Image">
                  <span class="plus sm">+5</span>
                </div>
              </div>											
            </div>
            <div class="activity-log">
              <p class="log-name">Yuki Hayashi<small class="log-time">- 7 hrs ago</small></p>
              <div class="log-details">Developed 30 multipurpose Bootstrap 4 Admin Templates</div>
            </div>
            <div class="activity-log">
              <p class="log-name">Nathan James<small class="log-time">- 9 hrs ago</small></p>
              <div class="log-details">Best Design Award</div>
            </div>
            <div class="activity-log">
              <p class="log-name">Elon Musk<small class="log-time">- 4 hrs ago</small></p>
              <div class="log-details">
                Farewell day photos uploaded.
                <div class="stacked-images mt-1">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user5.png') }}" alt="Profile Image">
                  <img class="sm" src="{{ URL::asset('assets/uploads/admin/img/user22.png') }}" alt="Profile Image">
                  <span class="plus sm">+7</span>
                </div>
              </div>											
            </div>
            <div class="activity-log">
              <p class="log-name">Nkio Toyoda<small class="log-time">- 3 hrs ago</small></p>
              <div class="log-details">Developed 30 multipurpose Bootstrap 4 Admin Templates</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <!-- Card start -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Items Sold</div>
      </div>
      <div class="card-body">
        <div class="customScroll5">
          <div class="products-sold-container">
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob1.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 11</div>
                  <div class="price">$999.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">8250</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob2.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 10</div>
                  <div class="price">$899.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">9347</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob3.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 9</div>
                  <div class="price">$799.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">6269</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob4.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 8</div>
                  <div class="price">$699.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">5950</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob5.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 7</div>
                  <div class="price">$599.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">2875</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob6.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 6</div>
                  <div class="price">$499.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">2300</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob7.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone 5</div>
                  <div class="price">$399.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">5150</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
            <div class="product">
              <div class="product-details">
                <img src="{{ URL::asset('assets/uploads/admin/img/mobiles/mob8.jpg') }}" alt="Apple iPhone 11">
                <div class="product-title">
                  <div class="title">Apple iPhone</div>
                  <div class="price">$299.00</div>
                </div>
              </div>
              <div class="product-sold">
                <div class="sold text-success">2195</div>
                <div class="sold-title">sold</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Card end -->
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Logs</div>
      </div>
      <div class="card-body">
        <div class="customScroll5">
          <div class="activity-logs">
            <div class="activity-log-list">
              <div class="sts"></div>
              <div class="log">New Item Sold</div>
              <div class="log-time">10:10</div>
            </div>
            <div class="activity-log-list">
              <div class="sts red"></div>
              <div class="log">Service Information</div>
              <div class="log-time">09:12</div>
            </div>
            <div class="activity-log-list">
              <div class="sts yellow"></div>
              <div class="log">Transaction Success</div>
              <div class="log-time">09:45</div>
            </div>
            <div class="activity-log-list">
              <div class="sts green"></div>
              <div class="log">Tasks Updated</div>
              <div class="log-time">06:50</div>
            </div>
            <div class="activity-log-list">
              <div class="sts"></div>
              <div class="log">New Registration</div>
              <div class="log-time">12:30</div>
            </div>
            <div class="activity-log-list">
              <div class="sts red"></div>
              <div class="log">Item Bought</div>
              <div class="log-time">04:22</div>
            </div>
            <div class="activity-log-list">
              <div class="sts yellow"></div>
              <div class="log">Message From Ivana</div>
              <div class="log-time">09:27</div>
            </div>
            <div class="activity-log-list">
              <div class="sts green"></div>
              <div class="log">18 Invoices paid</div>
              <div class="log-time">today</div>
            </div>
            <div class="activity-log-list">
              <div class="sts"></div>
              <div class="log">7 New Orders Received</div>
              <div class="log-time">12:30</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Top Links</div>
      </div>
      <div class="card-body">
        <div class="customScroll5">
          <ul class="bookmarks">
            <li>
              <a href="#">Bootstrap admin template</a>
            </li>
            <li>
              <a href="#">Images resources</a>
            </li>
            <li>
              <a href="#">Best admin templates 2020</a>
            </li>
            <li>
              <a href="#">Javascript libraries</a>
            </li>
            <li>
              <a href="#">Angular widgets</a>
            </li>
            <li>
              <a href="#">UX library</a>
            </li>
            <li>
              <a href="#">Bootstrap admin template</a>
            </li>
            <li>
              <a href="#">Images resources</a>
            </li>
            <li>
              <a href="#">Best admin templates 2020</a>
            </li>
            <li>
              <a href="#">Javascript libraries</a>
            </li>
            <li>
              <a href="#">Angular widgets</a>
            </li>
            <li>
              <a href="#">UX library</a>
            </li>
            <li>
              <a href="#">Bootstrap admin template</a>
            </li>
            <li>
              <a href="#">Images resources</a>
            </li>
            <li>
              <a href="#">Best admin templates 2020</a>
            </li>
            <li>
              <a href="#">Javascript libraries</a>
            </li>
            <li>
              <a href="#">Angular widgets</a>
            </li>
            <li>
              <a href="#">UX library</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="row gutters">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="social-tile">
          <div class="social-icon bg-info">
            <i class="icon-shopping-bag1"></i>
          </div>
          <div>New Products</div>
          <h2 class="text-grey">2500</h2>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="social-tile">
          <div class="social-icon bg-danger">
            <i class="icon-user1"></i>
          </div>
          <div>New Users</div>
          <h2 class="text-grey">25k</h2>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="upgrade-account">
            <h5>Account Upgrade</h5>
            <h6>Upgrade to PRO to earn more<br />revenue &amp; get benefits.</h6>
            <div class="custom-btn-group mt-2">
              <a href="pricing.html" class="btn btn-success ml-0"><i class="icon-trending-up"></i>Upgrade</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Row end -->
@endsection