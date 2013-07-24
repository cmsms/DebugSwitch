<?php

$lang = array(
  'installpostmessage' => 'Debug Switch has succesfuly been installed.',
  'help' => '<p>This module allows you to activate/deactivate the debug mode very easily.</p>
	
	<p>Sometimes the config.php cannot be edited. In this case, add those lines:</p>
	<textarea>
	 $config[\'debug\'] = false;
	    // --DEBUGSWITCH--
	    if(isset($_SESSION[\'debug\']))
	    {
	      $config[\'debug\'] = true;
	    }
	</textarea>

	<h3>DebugArea</h3>
	<p>You can use the tag DebugArea to only show some part when debug is activated.</p>
	<p>Example:</p>
	<textarea>
	    {DebugArea}My Test String{/DebugArea}
	</textarea>
	',
  );