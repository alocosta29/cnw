          <div class="wrap-footer">
              <div id="left-footer">
                  © Copyright 2016 - Todos os direitos reservados
              </div>
              <div id="center-footer">
                   <?php echo $this->Html->image('PublicLayout.logo.png', array('class'=>"logo-size")); ?>
                
              </div>
              <div id="right-footer">
                  <ul>
                           <li>
        <?php echo $this->Html->link('Home', array('plugin'=>false, 'controller'=>false, 'action'=>'index', 'admin'=>false)); ?>
        </li>
                      <li><?php echo $this->Html->link('A empresa', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa')); ?></li>
                      <li><?php echo $this->Html->link('Colunistas', array('plugin'=>false, 'controller'=>'public', 'action'=>'colunistas')); ?></li>
                      <li><?php echo $this->Html->link('Contato', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato')); ?></li>
                  </ul>
              </div>
          </div>
