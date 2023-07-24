@extends('layouts.site')

@section('content')

<section class="main-wrap">
    <div class="container">
        <div class="row">
@include('layouts.site_profile_menu')
            <div class="col-sm-9">
                <div class="rt-sec">
                    <div class="details-hdr">
                        <h2>Tenants</h2>
                    </div>
                    
                    <div class="box-body mar-top-30 no-padding">
                        <div class="table-responsive">
                        <table class="table no-margin" id="example2">
                            <thead>
                            <tr>
                                <th></th>	
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Mobile No</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="info">
                                <td></td>
                                <td>#21</td>
                                <td><img class="direct-chat-img" src="images/avatar2.png" alt=""></td>
                                <td>Sana Khan</td>
                                <td>Female</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>#72</td>
                                <td><img class="direct-chat-img" src="images/avatar.png" alt=""></td>
                                <td>Sohaib Fahim</td>
                                <td>Male</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td></td>
                                <td>#53</td>
                                <td><img class="direct-chat-img" src="images/avatar3.png" alt=""></td>
                                <td>Sana Khan</td>
                                <td>Female</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>#21</td>
                                <td><img class="direct-chat-img" src="images/avatar2.png" alt=""></td>
                                <td>Sana Khan</td>
                                <td>Female</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr class="info">
                                <td></td>
                                <td>#21</td>
                                <td><img class="direct-chat-img" src="images/avatar5.png" alt=""></td>
                                <td>Imran Khan</td>
                                <td>Male</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>#11</td>
                                <td><img class="direct-chat-img" src="images/avatar4.png" alt=""></td>
                                <td>Sohail Khan</td>
                                <td>Male</td>
                                <td>+88 321654987</td>
                                <td>
                                <a href="#"><i class="fa fa-eye"></i></a>
                                <a href="#" class="text-green"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="#" class="text-red"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>     
        </div>
    </div>
</section>
<script>

</script>
@endsection