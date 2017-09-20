<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <script type='text/javascript'>
          function getURLParameter(name, source) {
            return decodeURIComponent((new RegExp('[?|&|#]' + name + '=' +
              '([^&]+?)(&|#|;|$)').exec(source) || [,""])[1].replace(/\+/g,
              '%20')) || null;
          }

          var accessToken = getURLParameter("access_token", location.hash);

          if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
            window.location.replace('https://vertretungsplan.alexa.146programming.de/handle_login?access_token='+encodeURIComponent(accessToken));
          }
        </script>
    </head>
    <body>
        <p>Sie werden in Kürze weitergeleitet...</p>
    </body>
</html>
