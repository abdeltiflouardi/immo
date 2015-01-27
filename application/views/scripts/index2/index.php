<div id="content">
	<div id="ColLeft">
		<?php echo $this->render("menu.phtml"); ?>
	</div>
	<div id="ColRight">
<?php Zend_Debug::dump($this->print); ?>
<?php
echo $this->dateTextBox(
    'foo',
    '2008-07-11',
    array('required' => true)
);

echo "<br /> \n";


echo $this->numberSpinner(
    'fodddfro',
    5,
    array(
        'min'    => -10,
        'max'    => 10,
        'places' => 2,
    ),
    array(
        'maxlenth' => 3,
    )
);

echo "<br /> \n";

echo $this->numberTextBox(
    'fxccoo',
    5,
    array(
        'places' => 4,
        'type'   => 'percent',
    ),
    array(
        'maxlength' => 20,
    )
);

echo "<br /> \n";

echo $this->passwordTextBox(
    'fossso',
    '',
    array(
        'required' => true,
    ),
    array(
        'maxlength' => 20,
    )
);

echo "<br /> \n";

echo $this->radioButton(
    'foodd',
    'bar',
    array(),
    array(),
    array(
        'foo' => 'Foo',
        'bar' => 'Bar',
        'baz' => 'Baz',
    )
);

echo "<br /> \n";

echo $this->simpleTextarea(
    'fooee',
    'Start writing here...',
    array(),
    array('style' => 'width: 90%; height: 5ems;')
);

echo "<br /> \n";

echo $this->textarea(
    'foxeo',
    'Start writing here...',
    array(),
    array('style' => 'width: 300px;')
);

echo "<br /> \n";

echo $this->textBox(
    'fofo',
    'some text',
    array(
        'trim'       => true,
        'propercase' => true,
        'maxLength'  => 20,
    ),
    array(
        'size' => 20,
    )
);
echo "<br /> \n";

echo $this->timeTextBox(
    'foro',
    '',
    array(
        'am.pm'            => true,
        'visibleIncrement' => 'T00:05:00', // 5-minute increments
        'visibleRange'     => 'T02:00:00', // show 2 hours of increments
    ),
    array(
        'size' => 20,
    )
);
echo "<br /> \n";

echo $this->validationTextBox(
    'fozo',
    '',
    array(
        'required' => true,
        'regExp'   => '[\w]+',
        'invalidMessage' => 'No spaces or non-word characters allowed',
        'promptMessage'  => 'Single word consisting of alphanumeric ' .
                            'characters and underscores only',
    ),
    array(
        'maxlength' => 20,
    )
);
?>
	</div>
</div>