<?php 
$host = $_SERVER['HTTP_HOST'];
if(!$this->Session->read('Auth.User.id') and in_array($host , array('www.crescernaweb.com.br', 'www.crescernaweb.com', 'crescernaweb.com', 'crescernaweb.com.br'))) :?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-83016788-1', 'auto');
  ga('send', 'pageview');
</script>
<?php endif; ?>