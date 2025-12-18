<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $otp;

    public function __construct($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    public function build()
    {
        $htmlContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        </head>

        <body style="
            font-family: \'Inter\', \'Segoe UI\', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px 15px;
        ">
        
            <div style="
                max-width: 480px;
                margin: auto;
                background: #ffffff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            ">

                <!-- HEADER -->
                <div style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    padding: 30px;
                    text-align: center;
                    color: #fff;
                ">
                    <h2 style="
                        margin: 0;
                        font-size: 24px;
                        font-weight: 600;
                    ">
                        Kode Verifikasi Email
                    </h2>
                </div>

                <!-- BODY -->
                <div style="padding: 30px 35px;">

                    <p style="
                        font-size: 15px;
                        color: #555;
                        line-height: 1.7;
                        margin-bottom: 25px;
                    ">
                        Halo <strong style="color:#222;">'.$this->email.'</strong>, gunakan kode berikut untuk menyelesaikan proses verifikasi email Anda.
                    </p>

                    <!-- OTP BOX -->
                    <div style="
                        background: #f7f9fc;
                        border: 2px dashed #667eea;
                        border-radius: 12px;
                        padding: 22px;
                        text-align: center;
                        margin: 25px 0;
                        position: relative;
                    ">
                        <div style="
                            position: absolute;
                            top: -12px;
                            left: 50%;
                            transform: translateX(-50%);
                            background: #ffffff;
                            padding: 0 14px;
                            font-size: 13px;
                            font-weight: 600;
                            color: #667eea;
                        ">
                            KODE OTP
                        </div>

                        <div style="
                            font-family: \'Courier New\', monospace;
                            font-size: 28px;
                            font-weight: 700;
                            color: #333;
                            letter-spacing: 6px;
                        ">
                            '.$this->otp.'
                        </div>
                    </div>

                    <!-- INFO -->
                    <div style="
                        background: #eefbf1;
                        border-left: 4px solid #28a745;
                        padding: 14px 16px;
                        border-radius: 0 8px 8px 0;
                    ">
                        <p style="
                            margin: 0;
                            font-size: 14px;
                            color: #446;
                        ">
                            Kode ini berlaku selama <strong>10 menit</strong>. Jangan berikan kode ini kepada siapa pun.
                        </p>
                    </div>
                </div>

                <!-- FOOTER -->
                <div style="
                    background: #fafafa;
                    text-align: center;
                    padding: 22px;
                    font-size: 12px;
                    color: #888;
                    border-top: 1px solid #eee;
                ">
                    &copy; '.date('Y').' '.config('app.name').'. Semua hak dilindungi.
                </div>

            </div>

        </body>
        </html>
        ';

        return $this->subject('Kode OTP Verifikasi Email')
            ->html($htmlContent);
    }
}