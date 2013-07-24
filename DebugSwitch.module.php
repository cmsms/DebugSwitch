<?php

    /*
      Module: DebugSwitch - This module allows you to activate/deactivate the debug mode very easily.

      Copyrights: Jean-Christophe Cuvelier - 2013 ©
    */

    class DebugSwitch extends CMSModule
    {
        public function GetName()
        {
            return 'DebugSwitch';
        }

        public function GetFriendlyName()
        {
            return 'Debug Switch';
        }

        public function GetVersion()
        {
            return '1.0.0';
        }

        public function GetAuthor()
        {
            return 'Jean-Christophe Cuvelier';
        }

        public function GetAuthorEmail()
        {
            return 'jcc@atomseeds.com';
        }

        public function GetHelp()
        {
            return $this->Lang('help');
        }

        // public function GetChangeLog()         { return $this->Lang('changelog'); }
        // public function GetAdminDescription()  { return $this->Lang('admindescription'); }
        public function CheckAccess()
        {
            return $this->CheckPermission('Manage Debug Switch');
        }

        public function HasAdmin()
        {
            return true;
        }

        public function GetAdminSection()
        {
            return 'siteadmin';
        }

        public function VisibleToAdminUser()
        {
            return $this->CheckAccess();
        }

        public function InstallPostMessage()
        {
            return $this->Lang('installpostmessage');
        }

        public function UninstallPreMessage()
        {
            return $this->Lang('uninstallpremessage');
        }

        public function UninstallPostMessage()
        {
            return $this->Lang('uninstallpostmessage');
        }

        public function MinimumCMSVersion()
        {
            return '1.9';
        }

        public function GetDependencies()
        {
            return array(//  'CMSForms' => '0.0.24'
            );
        }

        public function install()
        {
            $this->CreatePermission('Manage Debug Switch', 'Manage Debug Switch');
            $this->modifyConfigFile();
        }

        public function uninstall()
        {
            $this->RemovePermission('Manage Debug Switch');
            $this->modifyConfigFile(false);
        }

        public function setParameters()
        {
            $this->InitializeFrontend();
        }

        public function InitializeFrontend()
        {
            if (isset($_SESSION['debug'])) {
                $this->smarty->assign('debug', true);
            }

            $this->smarty->register_block('DebugArea', array('DebugSwitch','DebugArea'));
        }

        public function modifyConfigFile($add = true)
        {
            $config = cms_utils::get_config();
            $c_file = $config['root_path'] . DIRECTORY_SEPARATOR . 'config.php';
            $data   = file_get_contents($c_file);
            if (strpos($data, '--DEBUGSWITCH--') !== false) {
                $data = str_replace($this->configCode(), '$config[\'debug\'] = false;', $data);
                file_put_contents($c_file, $data);
            } elseif ($add) {
                if (strpos($data, '$config[\'debug\'] = false;') !== false) {
                    $data = str_replace('$config[\'debug\'] = false;', $this->configCode(), $data);
                } else {
                    $data = str_replace('?>', $this->configCode() . "\n?>", $data);
                }
                file_put_contents($c_file, $data);
            }
        }

        private function configCode()
        {
            return '
            $config[\'debug\'] = false;
            // --DEBUGSWITCH--
            if(isset($_SESSION[\'debug\']))
            {
              $config[\'debug\'] = true;
            }
            ';
        }

        /**
         * @param array $params
         * @param string $content
         * @param string $template
         * @param boolean $repeat
         */

        public function DebugArea($params, $content, $template, &$repeat)
        {
            if (!$repeat) {
                if (isset($content)) {
                    if(isset($_SESSION['debug']))
                    {
                        echo $content;
                    }
                }
            }
        }
    }
