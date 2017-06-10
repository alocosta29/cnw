       <?php echo $this->Html->script(array('Layout.publicLayout/jquery.cycle.all.min', 
    'Layout.publicLayout/jquery.easing.1.3', 'Layout.publicLayout/jquery.custom')); ?>
    <style type="text/css">cufon{text-indent:0!important;}@media screen,projection{cufon{display:inline!important;display:inline-block!important;position:relative!important;vertical-align:middle!important;font-size:1px!important;line-height:1px!important;}cufon cufontext{display:-moz-inline-box!important;display:inline-block!important;width:0!important;height:0!important;overflow:hidden!important;text-indent:-10000in!important;}cufon canvas{position:relative!important;}}@media print{cufon{padding:0!important;}cufon canvas{display:none!important;}}</style>

<div class="feed">
    <div class="news-home">
        <div class="inner">
            <ul style="position: relative; width: 780px; height: 63px; overflow: hidden;">
                <?php if(!empty($articles)): ?>
                <?php foreach($articles as $article): ?>
                <li>
                    <?php 
                    echo $this->Html->link($article['titulo'], array('plugin'=>false, 'controller'=>'artigos', 'action'=>'ver', 'admin'=>false, $article['slug'])); ?>
                   | <?php echo $this->Complement->getMonth($this->Time->format('m', $article['data'])); ?> <?php echo  $this->Time->format('Y', $article['data']); ?></li>
                
                <?php 
                endforeach;
                endif; ?>
            </ul>
        </div>        
        <div class="clear"></div>
    </div>
 </div>