<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notification_templates = array(
            array('id' => '1', 'language_id' => '1', 'name' => 'Password Reset', 'email_from' => 'talk@gmail.com', 'template_key' => 'PASSWORD_RESET', 'subject' => 'Reset Your Password', 'short_keys' => '{"message":"message"}', 'email' => 'You are receiving this email because we received a password reset request for your account.[[message]]


This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.', 'sms' => '', 'in_app' => '', 'push' => '', 'status' => '{"mail":"1","sms":"0","in_app":"0","push":"0"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '2', 'language_id' => '1', 'name' => 'Verification Code', 'email_from' => 'talk@gmail.com', 'template_key' => 'VERIFICATION_CODE', 'subject' => 'Verification Code', 'short_keys' => '{"code":"code"}', 'email' => 'Your Email verification Code  [[code]]', 'sms' => 'Your SMS verification Code  [[code]]', 'in_app' => '', 'push' => '', 'status' => '{"mail":"1","sms":"1","in_app":"0","push":"0"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '3', 'language_id' => '1', 'name' => 'Two Step Enabled.', 'email_from' => 'talk@gmail.com', 'template_key' => 'TWO_STEP_ENABLED', 'subject' => 'Two step enabled.', 'short_keys' => '{"action":"Enabled Or Disable","ip":"Device Ip","time":"Time","code":"code"}', 'email' => 'Your verification code is: {{code}}', 'sms' => 'Your verification code is: {{code}}', 'in_app' => 'Your verification code is: {{code}}', 'push' => 'Your verification code is: {{code}}', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '4', 'language_id' => '1', 'name' => 'Two Step Disabled', 'email_from' => 'talk@gmail.com', 'template_key' => 'TWO_STEP_DISABLED', 'subject' => 'Two Step disabled', 'short_keys' => '{"time":"Time"}', 'email' => 'Google two factor verification is disabled.', 'sms' => 'Google two factor verification is disabled.', 'in_app' => 'Google two factor verification is disabled.', 'push' => 'Google two factor verification is disabled.', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '5', 'language_id' => '1', 'name' => 'Support Ticket Create', 'email_from' => 'talk@gmail.com', 'template_key' => 'SUPPORT_TICKET_CREATE', 'subject' => 'Support Ticket New', 'short_keys' => '{"ticket_id":"Support Ticket ID","username":"username"}', 'email' => '[[username]] create a ticket
Ticket : [[ticket_id]]', 'sms' => '[[username]] create a ticket
Ticket : [[ticket_id]]', 'in_app' => '[[username]] create a ticket
Ticket : [[ticket_id]]', 'push' => '[[username]] create a ticket
Ticket : [[ticket_id]]', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '1', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '6', 'language_id' => '1', 'name' => 'Admin Replied Ticket', 'email_from' => 'talk@gmail.com', 'template_key' => 'ADMIN_REPLIED_TICKET', 'subject' => 'Support Ticket Reply', 'short_keys' => '{"ticket_id":"Support Ticket ID"}', 'email' => 'Your support ticket has been replied by admin
Ticket : [[ticket_id]]', 'sms' => 'Your support ticket has been replied by admin
Ticket : [[ticket_id]]', 'in_app' => 'Your support ticket has been replied by admin
Ticket : [[ticket_id]]', 'push' => 'Your support ticket has been replied by admin
Ticket : [[ticket_id]]', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),

            array('id' => '7', 'language_id' => '1', 'name' => 'Payment Request to Admin', 'email_from' => 'talk@gmail.com', 'template_key' => 'PAYMENT_REQUEST', 'subject' => 'Payment Request', 'short_keys' => '{"username":"User","amount":"Amount","gateway":"Gateway"}', 'email' => '[[username]] request to payment [[amount]] by [[gateway]].', 'sms' => '[[username]] request to payment [[amount]] by [[gateway]].', 'in_app' => '[[username]] request to payment [[amount]] by [[gateway]].', 'push' => '[[username]] request to payment [[amount]] by [[gateway]].', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '1', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '8', 'language_id' => '1', 'name' => 'Payment Approved', 'email_from' => 'talk@gmail.com', 'template_key' => 'PAYMENT_APPROVED', 'subject' => 'Payment Approved', 'short_keys' => '{"username":"User","amount":"Amount","gateway":"Gateway"}', 'email' => '[[username]] request to payment [[amount]] by [[gateway]] is approved.', 'sms' => '[[username]] request to payment [[amount]] by [[gateway]] is approved.', 'in_app' => '[[username]] request to payment [[amount]] by [[gateway]] is approved.', 'push' => '[[username]] request to payment [[amount]] by [[gateway]] is approved.', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00'),
            array('id' => '9', 'language_id' => '1', 'name' => 'Payment Rejected', 'email_from' => 'talk@gmail.com', 'template_key' => 'PAYMENT_REJECTED', 'subject' => 'Payment Rejected', 'short_keys' => '{"username":"User","amount":"Amount","gateway":"Gateway"}', 'email' => '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', 'sms' => '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', 'in_app' => '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', 'push' => '[[username]] request to payment [[amount]] by [[gateway]] is rejected.', 'status' => '{"mail":"1","sms":"1","in_app":"1","push":"1"}', 'notify_for' => '0', 'lang_code' => 'en', 'created_at' => '2023-10-08 04:18:47', 'updated_at' => '2024-05-04 15:21:00')
        );

        DB::table('notification_templates')->insert($notification_templates);
    }
}
