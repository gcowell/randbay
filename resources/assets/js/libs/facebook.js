
var fbIsLoaded = false; // Our flag
window.fbAsyncInit = function() {
    FB.init({
        appId      : '318664548467496',
        xfbml      : true,
        version    : 'v2.7'
    });
    console.log('SDK loaded');
    fbIsLoaded = true;


};


(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


