<?php
/*
 * BitSHOK Starter Module
 * 
 * @author BitSHOK <office@bitshok.net>
 * @copyright 2012 BitSHOK
 * @version 1.0
 * @license http://creativecommons.org/licenses/by/3.0/ CC BY 3.0
 */

if (!defined('_PS_VERSION_')) exit;

class BskTwitterBox extends Module{
   
    public function __construct(){
        $this->name = 'bsktwitterbox'; // internal identifier, unique and lowercase
        $this->tab = 'other'; // backend module coresponding category
        $this->version = '1.0'; // version number for the module
        $this->author = 'BitSHOK'; // module author
        $this->need_instance = 0; // load the module when displaying the "Modules" page in backend

        parent::__construct();

        $this->displayName = $this->l('Twitter Box'); // public name
        $this->description = $this->l('Twitter Box for PrestaShop 1.5.x'); // public description
    }

    /*
     * Install this module
     */
    public function install(){
        if (!parent::install() ||
            !$this->registerHook('displayHeader') ||
            !$this->registerHook('displayRightColumn') )
                return false;
        
        $this->initConfiguration(); // set default values for settings
        
        return true;
    }

    /*
     * Uninstall this module
     */
    public function uninstall(){
        if (!parent::uninstall())
            Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.$this->name.'`');
        
        $this->deleteConfiguration(); // delete settings
        
        return parent::uninstall();
    }

    /*
     * Header of pages hook (Technical name: displayHeader)
     */
    public function hookHeader(){
        $this->context->controller->addCSS($this->_path.'style.css');
        
        $this->context->controller->addJqueryPlugin(array('scrollTo', 'serialScroll'));
        $this->context->controller->addJS($this->_path.'script.js');
    }
    
    /*
     * Top of pages (Technical name: displayTop)
     */
    public function hookTop(){
        $settings = unserialize( Configuration::get($this->name.'_settings') );
        
        $this->context->smarty->assign(array(
            'user'          => $settings['user'],
            'widget_id'     =>  $settings['widget_id'],
            'tweets_limit'  =>  $settings['tweets_limit'],
            'follow_btn'    => $settings['follow_btn']
        ));
        
        return $this->display(__FILE__, $this->name.'_scroll.tpl');
    }

    /*
     * Footer (Technical name: displayFooter)
     */
    public function hookFooter(){
        $settings = unserialize( Configuration::get($this->name.'_settings') );
        
        $this->context->smarty->assign(array(
            'user'          => $settings['user'],
            'widget_id'     =>  $settings['widget_id'],
            'tweets_limit'  =>  $settings['tweets_limit'],
            'follow_btn'    => $settings['follow_btn']
        ));
        
        return $this->display(__FILE__, $this->name.'.tpl');
    }
    
    /*
     * Left column blocks (Technical name: name:displayLeftColumn)
     */
    public function hookLeftColumn(){
        return $this->hookFooter();
    }
    
    /*
     * Right column blocks (Technical name: name:displayRightColumn)
     */
    public function hookRightColumn(){
        return $this->hookFooter();
    }
    
    /**
     * Configuration page
     */
    public function getContent(){
        $message = $this->processForm();
        $settings = unserialize( Configuration::get($this->name.'_settings') );
        
        $this->context->smarty->assign(array(
            'message'       => $message,
            'user'          => $settings['user'],
            'widget_id'     => $settings['widget_id'],
            'tweets_limit'  => $settings['tweets_limit'],
            'follow_btn'    => $settings['follow_btn']
        ));
        
        return $this->display(__FILE__, 'settings.tpl');
    }
    
    /**
     * Process data from Configuration page after form submition
     * @return string message
     */
    protected function processForm(){
        if(Tools::isSubmit('saveBtn')){ // save data
            $settings = array(
                'user'          => Tools::getValue('user'),
                'widget_id'     => Tools::getValue('widget_id'),
                'tweets_limit'  => Tools::getValue('tweets_limit'),
                'follow_btn'    => Tools::getValue('follow_btn')
            );
            Configuration::updateValue($this->name.'_settings', serialize($settings));
            
            // display success message
            return $this->displayConfirmation($this->l('The settings have been successfully saved!'));
        }
        
        return '';
    }
    
    /**
     * Set the default values for Configuration page settings
     */
    protected function initConfiguration(){
        $settings = array(
            'user'          => 'bitshok',
            'widget_id'     => '355763562850942976',
            'tweets_limit'  => 3,
            'follow_btn'    => 'on'
        );
        Configuration::updateValue($this->name.'_settings', serialize($settings));
    }
    
    /**
     * Delete configuration from database
     */
    protected function deleteConfiguration(){
        Configuration::deleteByName($this->name.'_settings');
    }
}