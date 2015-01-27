<?php echo $this->docType();
$this->dojo()->enable(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            $listeThemes = array('soria', 'tundra','nihilo','noir');
            $theme = $listeThemes[0];

            echo $this->headTitle() . "\n";

            $this->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
	                 ->appendHttpEquiv('Content-Language', 'fr-FR');


            echo $this->headMeta() . "\n";
           // echo $this->headLink()->setStylesheet('/public/css/backoffice_style.css') . "\n";
                if ($this->dojo()->isEnabled()):
                        $this	->dojo()->setLocalPath('/dojo/dojo/dojo.js')
                                ->addStyleSheetModule('dijit.themes.'  .  $theme);
?>


        <?php
                                echo $this->dojo();
                endif;
        ?>
    </head>
    <body class="<?php echo $theme;?>">
<?php echo $this->layout()->content;?>
  </body>
</html>