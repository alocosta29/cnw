<h1><?php echo $title_for_layout; ?></h1>
<span style="line-height: 30px; margin-bottom: 20px; width: 960px; height: auto; float: left; ">
<strong>Observação importante!</strong><br>
O catálogo de profissionais do ramo da construção foi desenvolvido com o intuito de <strong>facilitar o contato entre profissionais e clientes</strong>. 
<br>A Pavan <strong>NÃO POSSUI</strong> qualquer <strong>vínculo</strong> com os <strong>profissionais cadastrados</strong> no site e <strong>NÃO SE RESPONSABILIZA</strong> pelo trabalho dos mesmos.
</span>
<?php echo $this->Html->css('Layout.publicLayout/forms.css'); ?>
<section id="buscaProfissional">
        <?php echo $this->Form->create('Professional', array('class' => 'default2')); ?>
        <?php echo $this->Form->input('profession_id', array('label' => 'Profissão:', 'options'=>$listProfessions, 'empty'=>'Selecione uma profissão'), array( 'style'=>'width: 200px; ')); ?>
        <?php  echo $this->Form->input('nome', array('label' => 'Nome:', 'style'=>'width: 200px; ')); ?>
        <?php echo $this->Form->end(__('Filtrar')); ?>
</section>
<section id="resultsProfissional">
<?php if(!empty($listProfessionals)){ ?>   
    <?php foreach ($listProfessionals as $variavel): ?>
        <article id="professional-list">
            <h1><?php echo $variavel['Individual']['nome']; ?></h1>
            <h2><?php echo $variavel['Profession']['profession']; ?></h2>
            <?php if(!empty($variavel['Contact'])): ?>
                <h3>
                 <?php foreach($variavel['Contact'] as $contact): ?>
                        <?php 
                        $icon = $this->ReturnData->getIconProfessional($contact['contactstype_id']);
                        if(!empty($icon)){
                            echo $this->Html->image($icon, array('width'=>'15px')).' '; 
                        }else{
                            echo ' ';
                        }
                        echo $contact['contato'].'    '; ?>
                 <?php endforeach; ?>
                 </h3>
           <?php endif; ?>     
        </article>
<?php endforeach; ?>
<?php echo $this->element('paginacao'); ?>
<?php }else{ ?>
    <span style="color:#FF0000; margin-top: 50px; ">Profissional não localizado!</span>
<?php } ?>
</section>