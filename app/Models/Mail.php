<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class Mail extends Model{
    public static function getEmailTemplate() {
        return "
            <html>
                <body>
                    <h2>Hello, this is a test email!</h2>
                </body>
            </html>
        ";
    }
}
?>
