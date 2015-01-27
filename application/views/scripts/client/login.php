	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
		<div class="information">
			<?php echo sprintf($this->translate('dejaPasInscritMsg'), $this->url(array('controller'=>'client','action'=>'inscription'))); ?>
		</div>
		
		<?php 
			if(isset($this->message) && !empty($this->message)):
		?>
				<div class="error"><?php echo $this->message;?></div>
		<?php  
			endif;
		?>
		<fieldset>
			<legend><?php echo $this->translate('LoginCadre'); ?></legend>
			<?php echo $this->form; ?>
			
			<a href="javascript:void(0);" onclick="dijit.byId('divOM').show()">
				<?php echo str_replace(':', '',$this->translate('titrePassOublie')); ?>
			</a>
		</fieldset>
		
		<div 	dojoType="dijit.Dialog" 
				id="divOM" title="<?php echo $this->translate('titrePassOublie'); ?>" 
				execute="verifierEmail(arguments[0].email);" 
				style="display: none;">
    		
    		<p style="font-size: 11px;">
    		<?php echo $this->translate('passOublieDesc'); ?>
    		</p>  		
    		<input dojoType="dijit.form.TextBox" type="text" name="email" id="email">
    		<button dojoType="dijit.form.Button" type="submit"><?php echo $this->translate('Envoyer'); ?></button>
    		<div id="divOMsg" style="font-size: 11px;color:red;"></div>
    	</div>
    	
    	
		</div>	
	</div>