Goal
============
This library has the goal of make simple the creation and population of HTML forms

Usage example
=============

```
<?php
		require_once 'fg/load.php';

		$form = Form::create('formaction.php'); // form action attribute
		$form
			->add(Form::text('user[name]')->setLabel('Username: ')) // adds a text field with a name and wrapped with a div tag
			->add(Html::tag('br')) // adds a non-field object
			->add(Form::password('user[password]')->setLabel('Password: ')) // adds a password field with a name
			->add(Html::tag('br'))
			->add(
				Form::radios('gender') // create a collection of radio buttons
					->add('M', 'Male') // add a radio with value "M" and label "Male"
					->add('F', 'Female') // add a radio with value "F" and label "Female"
			)
			->add('<ul>')
			->add(
				Form::checkboxes('interests[]') // create a collection of checkboxeseaa
					->add('games', 'Games')
					->add('animes', 'Animes')
					->add('o_thing', 'Other things')
					->setWrapper(Html::tag('li')->setClass('li-item')) // changes the wrapper, default is div
			)
			->add('</ul>')
			->add(
				Form::select('songs[]')->setMultiple(true) // create a select multiple input
					->add('sth', 'Stairway to Heaven')
					->add('nem', 'Nothing Else Matters')
					->add('fb', 'Free bird')
					->add('others', 'Others')
			)
			->add(
				Form::checkbox('newsletter')->setLabel('Receive newsletter? ') // create a single checkbox
			);
		
		echo $form; // or echo $form->render()
```

If you wanna populate your form, you can use the populate method:

		
```
		$form->populate(array(
			'user' => array(
				'name' => 'myuser_name' // user[name] field
			),
			'songs' => array('sth', 'fb') // select these two songs for the field songs[]
			...
		));
```

ROADMAP
===============
* Write documentation