<?php
class Captcha
{
    private $width;
    private $height;
    private $captchaLength;
    private $captchaString;
    private $fontPath;
    function __construct($fontPath, $captchaLength = 6)
    {
        $this->width = (17 * $captchaLength) + 3;
        $this->height = 30;
        $this->captchaLength = $captchaLength;
        $this->fontPath = $fontPath;
    }
    private function setCaptchaText($captchaText)
    {
        $this->captchaString = $captchaText;
    }
    public function getCaptchaText()
    {
        return $this->captchaString;
    }
    public function getCaptchaImageBase64($isTextAllowed = false)
    {
        $width = $this->width;
        $height = $this->height;
        if ($isTextAllowed) {
            $string = str_shuffle('AaBbCcDdeEFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZ0123456789');
        } else {
            $string = str_shuffle('0123456789987654321012345678998765432101231456789554126548664');
        }
        $captchaString = substr($string, 0, $this->captchaLength);

        // Image background
        $image_plate = imagecreatetruecolor($width, $height);

        //Font
        $font = $this->fontPath;

        // Some color
        $white  = imagecolorallocate($image_plate, 255, 255, 255);
        $grey   = imagecolorallocate($image_plate, 128, 128, 128);
        $black = imagecolorallocate($image_plate, 0, 0, 0);

        // Draw rectange
        imagefilledrectangle($image_plate, 0, 0, $width, $height, $white);

        //NOISE

        // Draw background lines
        for ($i = 0; $i < 10; $i++) {
            imageline($image_plate, 0, rand() % $height, $width, rand() % 50, $grey);
        }

        // Draw pixel dot
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($image_plate, rand() % $width, rand() % $height, $grey);
        }

        // Add some shadow to the text
        imagettftext($image_plate, 17, 0, 8, 21, $black, $font, $captchaString);
        // Add the text
        imagettftext($image_plate, 17, 0, 9, 22, $black, $font, $captchaString);

        imagepng($image_plate, 'output.png');
        imagedestroy($image_plate);

        // Set captcha value
        $this->setCaptchaText($captchaString);

        // Set base64 string of image 
        $image = 'output.png';
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        unlink($image);

        // Return base64 string of image
        return $base64;
    }
    public function getCaptchaImage($isTextAllowed = false)
    {
        $width = $this->width;
        $height = $this->height;
        if ($isTextAllowed) {
            $string = str_shuffle('AaBbCcDdeEFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZ0123456789');
        } else {
            $string = str_shuffle('0123456789987654321012345678998765432101231456789554126548664');
        }
        $captchaString = substr($string, 0, $this->captchaLength);
        // Set captcha value
        $this->setCaptchaText($captchaString);

        // Image background
        $image_plate = imagecreatetruecolor($width, $height);

        // Set header
        header('Content-type:image/png');

        // Font
        $font = $this->fontPath;

        // Some color
        $white  = imagecolorallocate($image_plate, 255, 255, 255);
        $grey   = imagecolorallocate($image_plate, 128, 128, 128);
        $black = imagecolorallocate($image_plate, 0, 0, 0);

        // Draw rectange
        imagefilledrectangle($image_plate, 0, 0, $width, $height, $white);

        //NOISE

        // Draw background lines
        for ($i = 0; $i < 10; $i++) {
            imageline($image_plate, 0, rand() % $height, $width, rand() % 50, $grey);
        }

        // Draw pixel dot
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($image_plate, rand() % $width, rand() % $height, $grey);
        }

        // Add some shadow to the text
        imagettftext($image_plate, 17, 0, 8, 21, $black, $font, $captchaString);
        // Add the text
        imagettftext($image_plate, 17, 0, 9, 22, $black, $font, $captchaString);

        imagepng($image_plate);
        imagedestroy($image_plate);
    }
}
