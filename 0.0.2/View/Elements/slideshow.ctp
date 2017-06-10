  <?php $image = $this->Html->image('saiba-mais.png', array('class'=>'saiba-mais')); ?>
  
  <!-- Half Page Image Background Carousel Header -->
    <header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/img01.png)"></div>
                <div class="carousel-caption" style="text-align:right; ">
                    <?php echo $this->Html->link($image, array('plugin'=>false, 'controller'=>'public', 'action'=>'servicos'), array('escape'=>false)); ?>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/img02.png)"></div>
                <div class="carousel-caption" style="text-align:right; ">
                    <?php echo $this->Html->link($image, array('plugin'=>false, 'controller'=>'public', 'action'=>'servicos'), array('escape'=>false)); ?>
                </div>
            </div>
             <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url(img/img03.png)"></div>
                <div class="carousel-caption" style="text-align:right; ">
                   <?php echo $this->Html->link($image, array('plugin'=>false, 'controller'=>'public', 'action'=>'servicos'), array('escape'=>false)); ?>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>
    
      <!-- jQuery -->
  <?php echo $this->Html->script(array('Layout.publicLayout/jquery', 'Layout.publicLayout/bootstrap.min')); ?>
 
    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
<?php if(true == false): ?> 

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
 <?php endif; ?> 