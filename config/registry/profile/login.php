<?php

return [
    'model' =>  Webdecero\Manager\Api\Models\Admin::class,
    'redirectLogin' => '/sing-in',
    'redirectAuth' => '/dashboard',
    'redirectLogout' => '/',
    'redirectRecovery' => '/recovery-validate',
    'twoFactorsAuth'=>[
        'enable' => false,
        'redirect' => '/sign-validate',
        'channelsCodeMessage' => ['mail', 'whatsapp' ],
        'expirationCodeMinutes' => 15,
        'templateLanguage'=> 'es',
        'templateWhatsApp'=> 'verify_code',
        'countryCode'=> '52',
        'templateEmail'=> 'manager::mail.auth.send-code',
        'templateRecoveryPassword'=> 'manager::mail.login.recovery',
    ]
];
