<?php
if(isset($_POST['reCAPTCHA']) && $_POST['reCAPTCHA'] == 1){
    include_once('../captcha/captcha.php');
    $font = dirname(__FILE__).'/font.ttf';
    $captcha = new Captcha($font);
    $imgSource = $captcha->getCaptchaImageBase64();
    $captchaText = $captcha->getCaptchaText();
    echo json_encode(array('src'=>$imgSource,'data'=>$captchaText));
}
