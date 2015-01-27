<?php echo $this->docType(); 
$this->dojo()->enable(); ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <?php
 
 $listeThemes = array('soria', 'tundra','nihilo','noir');
 $theme = $listeThemes[0];
 $this->headTitle()->enableTranslation();
 
	echo $this->headTitle() . "\n";

	$this->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
	                 ->appendHttpEquiv('Content-Language', 'fr-FR');

	
	echo $this->headMeta() . "\n";
	echo $this->headLink()->setStylesheet('/public/css/layout.css') . "\n";
       // echo $this->headLink()->setStylesheet('/dojo/dojox/image/resources/Lightbox.css') . "\n";

	
    if ($this->dojo()->isEnabled()):
        $this	->dojo()->setLocalPath('/dojo/dojo/dojo.js')
            	->addStyleSheetModule('dijit.themes.'  .  $theme);

?>
<?php $this->dojo()->javascriptCaptureStart(); ?>
function fieldFile()
{
	obj = dojo.byId("fieldsFiles");
	newFile = document.createElement("input");
	newFile.setAttribute('type', 'file');	
	newFile.setAttribute('name', 'Images[]');
	
	obj.appendChild(newFile);
	
}

function supImg(id)
{
	if(confirm("Voulez-vous vraiment supprimer cette image?")){
		elem = "img" + id;
		obj = dojo.byId(elem)
		obj.parentNode.removeChild(obj);
		dojo.xhrGet( {
        		url: "/client/delimg/idImg/"+ id, 
        		handleAs: "text",

        		timeout: 5000,

		        load: function(response, ioArgs) {
		        
			        if ( 0 == response) {
						dojo.byId('divDelMsg').innerHTML = '<?php echo addslashes($this->translate('Erreur!')); ?>';
						dojo.byId('divDelMsg').style.color = "red";
					}else{
						dojo.byId('divDelMsg').innerHTML = '<?php echo addslashes($this->translate('ImgDeleted')); ?>';
						dojo.byId('divDelMsg').style.color = "green";
						fieldFile();
					}
					
		          return response;
		        },

		        error: function(response, ioArgs) {
		          dojo.byId("divDelMsg").innerHTML = "Erreur";
		          return response;
		          }
        	});		
	}
}

function verifierEmail(email)
{
	email = escape(email);
	if( email.length > 0 ){
		      dojo.xhrGet( {
        		url: "/client/verifieremail/email/"+ email, 
        		handleAs: "text",

        		timeout: 5000,

		        load: function(response, ioArgs) {
		        
			        if ( 0 == response) {
						dojo.byId('divOMsg').innerHTML = '<?php echo addslashes($this->translate('NoEmailExist')); ?>';
						dojo.byId('divOMsg').style.color = "red";
					}else{
						dojo.byId('divOMsg').innerHTML = '<?php echo addslashes($this->translate('EmailSent')); ?>';
						dojo.byId('divOMsg').style.color = "green";
					}
					
		          return response;
		        },

		        error: function(response, ioArgs) {
		          dojo.byId("divOMsg").innerHTML = "Erreur";
		          return response;
		          }
        	});		
	}else{
		dojo.byId('divOMsg').innerHTML = '<?php echo addslashes($this->translate('ZoneEmailVide')); ?>';
	}	
	
	dijit.byId('divOM').show();
}

<?php $this->dojo()->javascriptCaptureEnd()?>
<?php 
        echo $this->dojo()->requireModule('dojox.image.Lightbox')
        					->requireModule('dijit.Dialog')
        					->requireModule('dijit.Tooltip') . "\n";
	endif;
?>

<?php if(isset($this->enableJS) && $this->enableJS==true): ?>
	<style type="text/css">
	  @import "/dojo/dojox/image/resources/image.css";
	</style>
<?php endif; ?>
<style type="text/css">
    #divOM_underlay {
        background-color: gray;
    }
</style>

</head>
<body class="<?php echo $theme;?>">
	<div id="header">
		<img src="/public/images/ban.png" alt="" title="" />
	</div>
	<div id="navBar">&nbsp;<?php if(isset($this->username)): echo "Bienvenue " . $this->username; ?><br /><label class="logout"><a href="/client/logout">[Se déconnecter]</a></label><?php endif; ?></div>
			<?php echo $this->layout()->content ?>

<?php if( isset($this->listeOffres) and count($this->listeOffres) >= 3 ): ?>
	<div id="zoneOffres">
	<?php foreach($this->listeOffres as $offre): ?>
		<div class="zoneOffre">
			<div style="width: 122px; float: left;">
			<img 
					src="<?php echo My_Functions::getImg('/public/images/offres/',$offre["liste_images"][0]["nom_image"])?>"
					alt="" 
					width="120px" 
					height="120px"
			/>
			</div>
			<div style="width: 222px; float: left;">
			<?php echo $offre['nameTypeBien'];?><br />
			<?php echo $offre['prix'];?><br />
			<a href="<?php echo $this->url(array('controller'=>'annonce','action'=>'details','id'=>$offre['id_annonce'])); ?>">Voir détails</a> 
			</div>
		</div>
	<?php endforeach; ?>
	</div>	
<?php endif; ?>
	<div id="footer">
		Copyright &copy; 2009
	</div>
</body>
</html>
