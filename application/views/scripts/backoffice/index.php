<?php

$this->tabContainer()->captureStart('main-container',
                                    array('design' => 'headline'),
                                    array(
                                            'style'=>'height:400px;width:800px'
                                     ));

echo $this->contentPane(
 'stats',
 'Statistiques',
 array('refreshOnShow'=>true,'region' => 'top','title'=>'Statistiques',  'href' => $this->url( array( 'controller' => 'statsoffice', 'action' => 'index' ), 'default', false )),
 array('style' => 'background-color: white;')
);

echo  $this->contentPane(
 'clients',
 'Clients',
 array('refreshOnShow'=>true,'region' => 'left', 'title'=>'Clients', 'href' => $this->url( array( 'controller' => 'clientoffice', 'action' => 'index' ), 'default', false )),
 array('style' => 'width: 200px; background-color: white;')
);

echo $this->contentPane(
 'annonces',
 'Annonces block',
 array('refreshOnShow'=>true,'region' => 'bottom', 'title'=>'Annonces',  'href' => $this->url( array( 'controller' => 'annoncesoffice', 'action' => 'index' ), 'default', false )),
 array('style' => 'background-color: white;')
);

echo $this->tabContainer()->captureEnd('main-container');
?>