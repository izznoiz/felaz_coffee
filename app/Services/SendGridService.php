<?php

namespace App\Services;

use SendGrid\Mail\Mail;
use SendGrid;
use Exception;
use Illuminate\Support\Facades\Log;

class SendGridService
{
    protected $sendgrid;

    public function __construct()
    {
        $this->sendgrid = new SendGrid(env('SENDGRID_API_KEY'));
    }

    /**
     * Send email using SendGrid Web API
     */
    public function sendEmail($to, $subject, $content, $from = null, $fromName = null)
    {
        try {
            $email = new Mail();
            
            // Set sender
            $email->setFrom(
                $from ?: env('MAIL_FROM_ADDRESS'), 
                $fromName ?: env('MAIL_FROM_NAME')
            );
            
            // Set recipient
            $email->addTo($to);
            
            // Set subject and content
            $email->setSubject($subject);
            $email->addContent("text/html", $content);
            
            // Send email
            $response = $this->sendgrid->send($email);
            
            // Log response for debugging
            Log::info('SendGrid Response', [
                'status_code' => $response->statusCode(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);
            
            return $response->statusCode() == 202;
            
        } catch (Exception $e) {
            Log::error('SendGrid Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email with template
     */
    public function sendWithTemplate($to, $templateId, $dynamicData = [])
    {
        try {
            $email = new Mail();
            $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $email->addTo($to);
            $email->setTemplateId($templateId);
            
            if (!empty($dynamicData)) {
                $email->addDynamicTemplateDatas($dynamicData);
            }
            
            $response = $this->sendgrid->send($email);
            return $response->statusCode() == 202;
            
        } catch (Exception $e) {
            Log::error('SendGrid Template Error: ' . $e->getMessage());
            return false;
        }
    }
}