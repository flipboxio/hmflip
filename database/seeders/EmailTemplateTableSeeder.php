<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class EmailTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->truncate();

        DB::table('email_templates')->insert([
            ['temp_id' 	=> 1,
            'subject' 	=> "Your Payout information has been updated in {site_name}",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            We hope this message finds you well. Your {site_name} payout account information was recently changed on {date_time}. To help keep your account secure, we wanted to reach out to confirm that you made this change. Feel free to disregard this message if you updated your payout account information on {date_time}.
                            <br><br>
                            If you did not make this change to your account, please contact us.<br>",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 2,
            'subject' 	=> "Your Payout information has been updated in {site_name}",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            Your {site_name} payout information was updated on {date_time}.<br>",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 3,
            'subject' 	=> "Your Payout information has been deleted in {site_name}",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            Your {site_name} payout information was deleted on {date_time}.<br>",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 4,
            'subject' 	=> "Booking inquiry for {property_name}",
            'body' 		=> "Hi {owner_first_name},<h3>\r\n\r\nWe are pleased to inform you that your property {property_name}, has received a new booking request. Please review the details of the reservation below:&nbsp; &nbsp;</h3><div><br>\r\n            				{total_night} {night/nights} at {property_name}\r\n            				<br>\r\n            				{messages_message}\r\n            				<br>\r\n            				Property Name:  {property_name}</div><div>Guest\r\n\r\nName: {user_name}\r\n\r\n\r\n            				<br>Number of Guest: {total_guest}\r\n            				<br>\r\n            				Number of Night: {total_night}\r\n            				<br>\r\n                            Check in Time: {start_date}</div><div><br></div><div>-----------------</div><div><br></div><div>\r\n\r\n<p>To accept or decline this booking request, please log in to your host dashboard and navigate to the <b>\'Booking\'</b> section. We encourage you to respond to this request promptly to ensure a smooth booking process for both you and the guest.</p><p>If you have any questions or need further assistance, feel free to contact us.</p><p>Thank you for being a valued host on our platform.</p><p><b>Best regards,</b></p><p><b>{company_name}</b></p>\r\n\r\n<br></div>",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 5,
            'subject' 	=> "Please confirm your e-mail address",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            Welcome to {site_name}! Please confirm your account.",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 6,
            'subject' 	=> "Reset your Password",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            Your requested password reset link is below. If you didn't make the request, just ignore this email.",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 7,
            'subject' 	=> "Please set a payment account",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            Amount {currency_symbol}{payout_amount} is waiting for you but you did not add any payout account to send the money. Please add a payout method.",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 8,
            'subject' 	=> "Payout Sent",
            'body' 		=> "Hi {first_name},
                            <br><br>
                            We've issued you a payout of  {currency_symbol}{payout_amount} via PayPal. This payout should arrive in your account, taking into consideration weekends and holidays.",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=> 1],

            ['temp_id' 	=> 9,
            'subject' 	=> "Booking Cancelled",
            'body' 		=> "Hi {owner_first_name},
                            <br><br>
                            {user_first_name} cancelled booking of {property_name}.<br>",
            'lang' 		=> 'en',
            'type' 		=> 'email',
            'lang_id' 	=>  1],

            ['temp_id'  => 10,
            'subject'   => "Booking {Accepted/Declined}",
            'body'      => "Hi {guest_first_name},
                            <br><br>
                            {host_first_name} {Accepted/Declined} the booking of {property_name}.<br>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'     => 11,
            'subject'   => "Booking request send for {property_name}",
            'body'      => "Hi {user_first_name},
                            <br><br>
                            <h1>Booking request send to {owner_first_name}</h1>
                            <br>
                            {total_night} {night/nights} at {property_name}
                            <br>
                            Property Name:  {property_name}
                            <br>
                            Number of Guest: {total_guest}
                            <br>
                            Number of Night: {total_night}
                            <br>
                            Check in Time: {start_date}",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 12,
            'subject'   => "Booking Confirmation for {property_name}",
            'body'      => "Hi {user_first_name},<div><p>\r\n\r\n<b>We are delighted to confirm your booking at {property_name}. Below are the details of your reservation:</b></p><div><ul><li>\r\n                            <b>Property Name:</b>  {property_name}\r\n                            </li><li>\r\n                            <b>Number of Guest:</b> {total_guest}\r\n                            </li><li>\r\n                            <b>Number of Night:</b> {total_night}\r\n                            </li><li>\r\n                            <b>Check in Time:</b> {start_date}\r\n                            </li><li><b>Total Amount:</b> {total_amount}</li></ul></div></div><div><br></div><div>\r\n\r\n-----------&nbsp;</div><div><br></div><div>If you have any questions or need further assistance, please do not hesitate to contact us.&nbsp;</div><div>We look forward to hosting you at \r\n\r\n{property_name}\r\n\r\n.&nbsp;</div><div><br></div><div><b>Best regards,&nbsp;</b></div><div><b>{company_name}</b><br></div>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 13,
            'subject'   => "Property Booked by {user_first_name}",
            'body'      => "Hi {owner_first_name},<br><br>\r\n                            <h3>\r\n\r\n<b>We are excited to inform you that your property - {property_name}, has been successfully booked by {user_first_name}. Below are the details of the reservation:</b></h3>\r\n                            \r\n\r\n<div><p><b>Booking Details:</b></p><div><ul><li><b>Property Name:</b>  {property_name}\r\n                            </li><li>\r\n                            <b>Number of Guest:</b> {total_guest}\r\n                            </li><li>\r\n                            <b>Number of Night:</b> {total_night}\r\n                            </li><li>\r\n                            <b>Check in Time:</b> {start_date}\r\n                            </li><li><b>Total Amount:</b> {total_amount}</li></ul></div></div><div><br></div><div><b>Guest Details:</b></div><div><ul><li><b>Name:</b> {user_name}\r\n\r\n</li><li><b>Email:</b> {user_email}</li></ul></div><div><br></div><div>----------</div><div>\r\n\r\n<p>Please ensure that the property is prepared for the guest\'s arrival on the specified dates. We recommend providing them with any necessary check-in instructions or additional details.</p><p>If you have any questions or need further assistance, feel free to contact us.</p><p>Thank you for using our platform to host guests. We appreciate your cooperation and wish you a pleasant experience with your guest.</p><p>\r\n\r\n</p><p><b>Best regards,</b></p><p><b>{company_name}</b></p><p></p></div>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 14,
            'subject'   => "Payment has been made for {property_name}",
            'body'      => "Hi {admin_first_name},\r\n                            <br><br>\r\n                            <h3>We wanted to inform you that a payment has been successfully processed for a property booking. Below are the details:\r\n\r\n</h3><ul><li>\r\n                            <b>Guest Name: </b>{user_name}</li><li>\r\n                            <b>Property Booked:</b>  {property_name}</li><li><b>Payment method:</b> {payment_method}</li><li><b>Payment Amount:</b> {total_amount}</li></ul><div><br>{bankMessages}</div><div><br></div><div>--------------------</div><div>\r\n\r\n<p>If you require any further information or assistance, please don\'t hesitate to reach out.</p><p>Thank you for your attention to this matter.</p><p>\r\n\r\n<b>Best regards,\r\n</b><br><b>{company_name}</b><br></p>\r\n\r\n<br></div>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 15,
            'subject'   => "New Payout Request Notification",
            'body'      => "Hi {admin_first_name},\r\n                            <br><br>\r\n                            <h3>\r\n\r\nWe are writing to inform you that a new payout request has been made. Below are the details of the request:</h3>\r\n                            \r\n\r\n<ul><li><strong>Requestor\'s Name</strong>: {user_name}</li><li><b>Payout Via</b>: {payout_method}</li><li><strong>Requestor\'s Email</strong>: {user_email}</li><li><strong>Amount Requested</strong>: {requested_amount}</li><li><strong>Date of Request</strong>: {requested_date}</li></ul>------------<div>\r\n\r\n<p>Please review and process this payout request at your earliest convenience. If you have any questions or require further information, do not hesitate to contact us.</p><p>Thank you for your attention to this matter.</p><p><b>Best regards,</b></p><p><b>{company_name}</b></p>\r\n\r\n<br></div>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 16,
            'subject'   => "Approval Request for Newly Listed Property - {property_name}",
            'body'      => "Hi {admin_first_name},\r\n                            <br><br>\r\n                            <h3>\r\n\r\nWe writing to inform you that {host_name} have listed a new property on our platform. Kindly review and approve the listing at your earliest convenience. Below are the details of the property:</h3>\r\n                            \r\n\r\n<ul><li>\r\n                            <b>Property Name:</b>  {property_name}\r\n                            </li><li><strong>Property Address</strong>: {property_address}</li><li><strong>Date Listed</strong>: {listed_date}</li></ul>\r\n\r\n\r\n                            --------------------<div>\r\n\r\n<p>Please let us know if there are any further details or modifications needed.</p><p>Thank you for your prompt attention to this matter.</p><p><b>Best regards,</b><br><b>{company_name}</b></p>\r\n\r\n<br></div>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

            ['temp_id'  => 17,
            'subject'   => "Payout Request Approved and Processed",
            'body'      => "Hi {user_name},<br>\r\n                            <h1></h1>\r\n\r\n<h3>We are pleased to inform you that your payout request has been accepted. The requested amount has been sent to your selected payment method. Below are the details of your payout:</h3><ul><li><strong>Amount</strong>: {total_amount}</li><li><strong>Payment Method</strong>: {payment_method}</li><li><strong>Date Processed</strong>: {accepted_date}</li></ul>----------<br><p>If you have any questions or need further assistance, please do not hesitate to contact us.</p><p>Thank you for using our services.</p><p><b>Best regards,</b></p><p><b>{company_name}</b></p>",
            'lang'      => 'en',
            'type'      => 'email',
            'lang_id'   => 1],

        ]);

    }
}
