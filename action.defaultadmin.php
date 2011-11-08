<?php
if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if(isset($params['activate']))
{
  $_SESSION['debug'] = true;  
  $this->Redirect($id, 'defaultadmin');
}

if(isset($params['deactivate']))
{
  unset($_SESSION['debug']);
  $this->Redirect($id, 'defaultadmin');
}



if(isset($_SESSION['debug']))
{
  echo $this->CreateLink($id, 'defaultadmin', $returnid, 'Desactivate debug', array('deactivate' => 1));
}
else
{
  echo $this->CreateLink($id, 'defaultadmin', $returnid, 'Activate debug', array('activate' => 1));
}