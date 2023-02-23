<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 定义邮箱类，用于发送邮箱验证码
 */
class VerifyCode extends Mailable
{
    use Queueable, SerializesModels;


    private $title;
    private $views;
    private $address;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$views,$address,array $data)
    {
        $this->title=$title;
        $this->views=$views;
        $this->address=$address;
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->to($this->address)
            ->view($this->views)->with($this->data);
    }
}
