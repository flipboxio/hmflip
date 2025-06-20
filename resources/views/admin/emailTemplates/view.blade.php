@extends('admin.template')

@section('main')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Email Templates</h1>
        @include('admin.common.breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                @include('admin.common.mail_menu')
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            @if ($tempId == 1)
                                {{ "Account Information Default Update Template" }}

                            @elseif ($tempId == 2)
                                {{ "Account Information Update Template" }}

                            @elseif ($tempId == 3)
                                {{ "Account Information Delete Template" }}

                            @elseif ($tempId == 4)
                                {{ "Booking Template" }}

                            @elseif ($tempId == 5)
                                {{ "Email Confirm Template" }}

                            @elseif ($tempId == 6)
                                {{ "Forget Password Template" }}

                            @elseif ($tempId == 7)
                                {{ "Need Payment Account Template" }}

                            @elseif ($tempId == 8)
                                {{ "Payout Sent Template" }}

                            @elseif ($tempId == 9)
                                {{ "Booking Cancelled Template" }}

                            @elseif ($tempId == 10)
                                {{ "Booking Accepted/Declined Template" }}

                            @elseif ($tempId == 11)
                                {{ "Booking Request Send Template" }}

                            @elseif ($tempId == 12)
                                {{ "Booking Confirmation Template" }}

                            @elseif ($tempId == 13)
                                {{ "Property Booking Notify Template" }}

                            @elseif ($tempId == 14)
                                {{ "Property Booking Payment Notify Template" }}

                            @elseif ($tempId == 15)
                                {{ "Payout Request Received Template" }}

                            @elseif ($tempId == 16)
                                {{ "Property Listing Approved Template" }}

                            @elseif ($tempId == 17)
                                {{ "Payout Request Approved Template" }}

                            @endif
                        </h3>

                        <button class="float-right btn btn-success" id="available">Available Variable</button>
                    </div>
                    <div class="box-header d-none" id="variable">
                        @if ($tempId == 1)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Site Name : {site_name}</p>
                                    <p>First Name : {first_name}</p>
                                    <p>Date Time : {date_time}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 2)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Site Name : {site_name}</p>
                                    <p>First Name : {first_name}</p>
                                    <p>Date Time : {date_time}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 3)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Site Name : {site_name}</p>
                                    <p>First Name : {first_name}</p>
                                    <p>Date Time : {date_time}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 4)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Start Date : {start_date}</p>
                                    <p>Total Guest : {total_guest}</p>
                                    <p>Message : {messages_message}</p>
                                    <p>Night : {night/nights}</p>
                                    <p>Payment Method: {payment_method}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Property Name : {property_name}</p>
                                    <p>Owner First Name : {owner_first_name}</p>
                                    <p>User First Name : {user_first_name}</p>
                                    <p>Total Nights : {total_night}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 5)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>First Name : {first_name}</p>
                                    <p>Site Name : {site_name}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 6)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>First Name : {first_name}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 7)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>First Name : {first_name}</p>
                                    <p>Currency Symbol : {currency_symbol}</p>
                                    <p>Payout Amount : {payout_amount}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 8)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Site Name : {site_name}</p>
                                    <p>First Name : {first_name}</p>
                                    <p>Currency Symbol : {currency_symbol}</p>
                                </div>
                                <div class="col-md-6">
                                    <p>Payout Amount : {payout_amount}</p>
                                    <p>Payment Method : {payout_payment_method}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 9)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Accepted/Declined : {Accepted/Declined}</p>
                                    <p>Guest First Name : {guest_first_name}</p>
                                    <p>Host First Name : {host_first_name}</p>
                                    <p>Property Name : {property_name}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 10)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Accepted/Declined : {Accepted/Declined}</p>
                                    <p>Guest First Name : {guest_first_name}</p>
                                    <p>Host First Name : {host_first_name}</p>
                                    <p>Property Name : {property_name}</p>
                                </div>
                            </div>

                        @elseif ($tempId == 11)
                            <div class="row ">
                                <div class="col-md-6">
                                    <p>Host name : {owner_first_name}</p>
                                    <p>Total Night : {total_night}</p>
                                    <p>User First Name : {user_first_name}</p>
                                    <p>Number of Guest : {total_guest}</p>
                                    <p>Property Name : {property_name}</p>
                                    <p>Check-in Time : {start_date}</p>
                                </div>
                            </div>
                        @elseif ($tempId == 12)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>Total Night : {total_night}</p>
                                <p>User First Name : {user_first_name}</p>
                                <p>Number of Guest : {total_guest}</p>
                                <p>Property Name : {property_name}</p>
                                <p>Check-in Time : {start_date}</p>
                                <p>Total amount : {total_amount}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @elseif ($tempId == 13)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>Host name : {owner_first_name}</p>
                                <p>Guest first name : {guest_first_name}</p>
                                <p>Guest full name : {guest_name}</p>
                                <p>Guest email : {guest_email}</p>
                                <p>Total Night : {total_night}</p>
                                <p>User First Name : {user_first_name}</p>
                                <p>Number of Guest : {total_guest}</p>
                                <p>Property Name : {property_name}</p>
                                <p>Check-in Time : {start_date}</p>
                                <p>Total amount : {total_amount}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @elseif ($tempId == 14)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>Admin name : {admin_first_name}</p>
                                <p>Guest full name : {guest_name}</p>
                                <p>Property Name : {property_name}</p>
                                <p>Payment method : {payment_method}</p>
                                <p>Payment amount : {payment_amount}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @elseif ($tempId == 15)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>Admin name : {admin_first_name}</p>
                                <p>Requestor's full name : {user_name}</p>
                                <p>Requestor's email : {user_email}</p>
                                <p>Payment method : {payment_method}</p>
                                <p>Requested amount : {requested_amount}</p>
                                <p>Requested date : {requested_date}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @elseif ($tempId == 16)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>Admin name : {admin_first_name}</p>
                                <p>Host name : {host_name}</p>
                                <p>Property Name : {property_name}</p>
                                <p>Property address : {property_address}</p>
                                <p>Listed date : {listed_date}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @elseif ($tempId == 17)
                        <div class="row ">
                            <div class="col-md-6">
                                <p>User name : {user_name}</p>
                                <p>Total Amount : {total_amount}</p>
                                <p>Payment method : {payment_method}</p>
                                <p>Accepteance Date : {accepted_date}</p>
                                <p>Company Name : {company_name}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <form action='{{ url("admin/email-template/" . $tempId) }}' method="post" id="myform">
                {!! csrf_field() !!}
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <label class="fw-bold mb-2" for="exampleInputEmail1">Subject</label>
                            <input class="form-control f-14" name="en[subject]" type="text" value="{{ $temp_Data[0]->subject }}">
                            <input type="hidden" name="en[id]" value="1">
                        </div>

                        <div class="form-group">
                            <textarea id="compose-textarea" name="en[body]" class="form-control f-14 editor" style="height: 300px">
                                {{ $temp_Data[0]->body }}
                            </textarea>
                        </div>

                        <div class="box-group" id="accordion">
                            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                            @foreach ($languages as $key => $language)
                            <!-- Escape the english details -->
                                @php if ($language->short_name == 'en') {continue;} @endphp

                                <div class="panel box mt-3">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapse{{ $language->short_name }}" aria-expanded="false" class="collapsed">
                                            {{ $language->name }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapse{{ $language->short_name }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="box-body">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Subject</label>
                                                <input class="form-control f-14" name="{{ $language->short_name }}[subject]" type="text" value="{{ isset($temp_Data[$key]->subject) ? $temp_Data[$key]->subject : 'Subject' }}">

                                                <input type="hidden" name="{{ $language->short_name }}[id]" value="{{ $language->id }}">
                                            </div>

                                            <div class="form-group">
                                                <textarea id="compose-textarea" name="{{ $language->short_name }}[body]" class="form-control f-14 editor" style="height: 300px">
                                                    {{ isset($temp_Data[$key]->body) ? $temp_Data[$key]->body : 'Body' }}
                                                </textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-flat f-14">Update</button>
                        </div>
                    </div>
                </form>
                <!-- /.box-footer -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </section>
</div>
@endsection

<script src="{{ asset('public/backend/js/backend.min.js') }}"></script>

