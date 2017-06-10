<div class='main' style="margin-bottom: 30px;">
<h2 style="font-size: 22px; ">CNW - Crescer na Web <?php echo CNW_VERSION; ?> </h2>


 <?php if (isset($database)): ?>
    <fieldset > <legend>Dados disponíveis somente aos perfis Superuser ou Administrador</legend>
        - Base de Dados:<br/><?php
        $i=0;
        foreach ($database as $db => $dbval) {
            $i++;
            echo '&nbsp;&nbsp;&nbsp;'.$i.') '.$db.' em '.$dbval.'<br />';
        }
        ?>
        - <?php echo $_SERVER['SERVER_SOFTWARE'];?><br/>
        - IP servidor: <?php echo $_SERVER['SERVER_ADDR'];?><br/>
        - Seu IP: <?php echo $_SERVER['REMOTE_ADDR'];?><br/>
        - PHP/Version: <?php echo phpversion();?><br/>
    </fieldset>
    <?php endif; ?>


</div>
