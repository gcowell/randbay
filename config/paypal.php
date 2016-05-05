<?php
return array(
    // set your paypal credential
    'client_id' => 'AUTTojfo43yFVr1SM5kKSZdtR8ImXPc3MdtsbQpDnQV_ni7Z9CyJmTUaAMxNinORAEdVvtklDuQ6OvVk',
    'secret' => 'EFtMCZ_C2z4UrIgPD89ycBoJ0mgwiwx4hGIbeaJtIz2poqbcPXn9vEyVLezYTopF-7_0lN1O-R9MTlrW',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
