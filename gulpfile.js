process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.sass('app.scss', 'resources/assets/css');


    mix.styles
        ([

            'libs/jquery-ui.css',
            'libs/jquery-ui.structure.css',
            'libs/jquery-ui.theme.css',
            'libs/bootstrap.min.css',
            'libs/jquery.fancybox.css',
            'app.css'

        ]);


    mix.scripts
        ([
            'libs/jquery.min.js',
            'libs/jquery-ui.min.js',
            'libs/bootstrap.min.js',
            'libs/html5.shiv.js',
            'libs/respond.min.js',
            'libs/jquery.wait.js',
            'libs/jquery.cookie.js',
            'libs/jquery.fancybox.js',
            'libs/jquery.fancybox.pack.js',
            'libs/facebook.js',
            'SaleItemForm.js',
            'BuyOrderForm.js',
            'BuyOrderMatch.js',
            'Homepage.js',
            'How.js',
            'AdminSaleitems.js',
            'MailingList.js'

        ]);


});
