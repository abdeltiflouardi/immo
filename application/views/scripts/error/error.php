	<div id="content">
		<div id="ColLeft">
			<?php echo $this->render("menu.phtml"); ?>
		</div>
		<div id="ColRight">
<h2><?php echo $this->message ?></h2>

<?php //if ('development' == $this->env): ?>
    <h3>Exception information:</h3> 
    <p>
        <b>Message:</b> <?php echo $this->exception->getMessage() ?>
    </p> 

    <h4>Stack trace:</h4> 
    <p><?php echo str_replace('#', '<br />#', $this->exception->getTraceAsString()) ?></p>

    <h3>Request Parameters:</h3> 
    <pre><?php var_dump($this->request->getParams()) ?></pre> 
<?php //endif ?>
		</div>	
	</div>