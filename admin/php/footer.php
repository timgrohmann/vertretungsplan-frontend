        <script type="text/javascript">
            $('#menuOpener').click(function(){
                $('nav').addClass('open');
                $('main').addClass('blurredOut');
                $('.infoBar').removeClass('open');
            });
            $('#menuCloser').click(function(){
                $('main').removeClass('blurredOut');
                $('nav').removeClass('open');
            });

            $('#infoOpener').click(function(){
                $('.infoBar').addClass('open');
                $('main').addClass('blurredOut');
                $('nav').removeClass('open');
            });
            $('#infoCloser').click(function(){
                $('main').removeClass('blurredOut');
                $('.infoBar').removeClass('open');
            });
        </script>
    </body>
</html>
