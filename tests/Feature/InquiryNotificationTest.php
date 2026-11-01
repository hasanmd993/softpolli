<?php

namespace Tests\Feature;

use App\Mail\NewInquiryReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InquiryNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submission_sends_notification_mail()
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '+1234567890',
            'subject' => 'Web App Development',
            'message' => 'Need a modern Laravel + Vue platform built.',
        ]);

        $response->assertSessionHas('success');

        Mail::assertSent(NewInquiryReceived::class, function ($mail) {
            return $mail->inquiry->email === 'alice@example.com' &&
                   $mail->inquiry->type === 'contact';
        });
    }

    public function test_quote_form_submission_sends_notification_mail()
    {
        Mail::fake();

        $response = $this->post('/quote', [
            'name' => 'Bob Smith',
            'email' => 'bob@example.com',
            'phone' => '+1987654321',
            'company' => 'Smith Enterprises',
            'service' => 'Full-Stack Development',
            'selected_features' => ['Payment Integration', 'Admin Dashboard'],
            'budget_range' => '$5,000 - $10,000',
            'timeline' => '1 - 2 Months',
            'message' => 'Looking to start next month.',
        ]);

        $response->assertSessionHas('success');

        Mail::assertSent(NewInquiryReceived::class, function ($mail) {
            return $mail->inquiry->email === 'bob@example.com' &&
                   $mail->inquiry->type === 'quote';
        });
    }
}
