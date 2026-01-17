<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailModel extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $subjectLine;
    public $template;

    /**
     * Create a new message instance.
     */
    public function __construct($details, $subjectLine = null, $template = null)
    {
        $this->details = $details;
        $this->subjectLine = $subjectLine;
        $this->template = $template;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->subjectLine ?? 'Mail From ImpurityX';

        // Pass $details array as individual variables to Blade
        return $this->subject($subject)
                    ->view($this->template ?? 'emails.template')
                    ->with($this->details);
    }
}
?>
