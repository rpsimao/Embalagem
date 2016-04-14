<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRegistry ()
    {

	    switch (APPLICATION_ENV) {
            case "development":
                Zend_Registry::set('embalagem',   new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'embalagem_testing'));
                Zend_Registry::set('optimus',     new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'optimus'));
                Zend_Registry::set('ocorrencias', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'ocorrencias'));
                break;
            case "casa":
                Zend_Registry::set('embalagem',   new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'embalagem_casa'));
                Zend_Registry::set('optimus',     new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'optimus_casa'));
                Zend_Registry::set('ocorrencias', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'ocorrencias_casa'));
                break;
            default:
                Zend_Registry::set('embalagem',   new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'embalagem'));
                Zend_Registry::set('optimus',     new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'optimus'));
                Zend_Registry::set('ocorrencias', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'ocorrencias'));
                break;
        }
        Zend_Registry::set('backstage', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'backstage'));
        Zend_Registry::set('braille',   new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'braille'));
        Zend_Registry::set('pruebas',   new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'pruebas'));
        Zend_Registry::set('mail_server', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'mail_server'));
        Zend_Registry::set('phpurl', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'phpurl'));
	    Zend_Registry::set('passwords', new Zend_Config_Ini(APPLICATION_PATH . '/configs/local.ini', 'passwords'));
	    Zend_Registry::set('home_links', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'home_links'));
    }

    protected function _initHeader ()
    {

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->addHelperPath("App/View/Helper", "App_View_Helper");
        $view->doctype("XHTML1_STRICT");
        $view->headTitle('Fernandes &amp; Terceiro, S.A. :: Embalagem Database');
        $view->headLink()->appendStylesheet('/css/style1.css');
        $view->headLink()->appendStylesheet('/css/tables.css');
        $view->headLink()->appendStylesheet('/css/menu.css');
        $view->headLink()->appendStylesheet('http://cdn.fterceiro.pt/library/js/jqueryui/themes/redmond/jquery-ui.css');
        $view->headLink()->appendStylesheet('http://cdn.fterceiro.pt/library/js/jqueryui/themes/redmond/jquery.ui.theme.css');
        $view->headLink()->appendStylesheet('http://static.fterceiro.pt/messages/messages.css');
        $view->headLink()->headLink(array('rel' => 'favicon' , 'href' => '/images/favicon.ico'), 'PREPEND');
        $view->headLink()->headLink(array('rel' => 'icon' , 'href' => '/images/favicon.ico'), 'PREPEND');
        $view->headMeta()->appendHttpEquiv('Content-Language', 'pt-PT');
        $view->headMeta()->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1');
        $view->headMeta()->appendName('Author', 'Ricardo Simao');
        $view->headMeta()->appendName('Email', 'ricardo.simao@fterceiro.pt');
        $view->headMeta()->appendName('Copyright', 'Fernandes e Terceiro, S.A.');
        $view->headMeta()->appendName('Zend Framework', Zend_Version::VERSION);
        $view->headMeta()->appendName('PHP',  phpversion());
        $view->headMeta()->appendName('Version', '@@BuildNumber@@');
        $view->headMeta()->appendName('BuildDate', '@@BuildDate@@');
        /*$view->headScript()->appendFile('http://cdn.fterceiro.pt/library/js/jquery/latest/min.js', 'text/javascript');
        $view->headScript()->appendFile('http://cdn.fterceiro.pt/library/js/jqueryui/latest/min.js', 'text/javascript');
        $view->headScript()->appendFile('/js/menu.js', 'text/javascript');
        $view->headScript()->appendFile('/js/jquery.clipboard.min.js', 'text/javascript');*/
	    $view->headScript()->appendFile('/js/f3.js', 'text/javascript');
        $view->headLink()->appendStylesheet('http://cdn.fterceiro.pt/library/css/css3buttons.css');
        
    }

	protected function _initValidateTranslation()
	{
		$translator = new Zend_Translate(
			array(
				'adapter' => 'array',
				'content' => APPLICATION_PATH . '/languages/resources/',
				'locale'  => new Zend_Locale('pt_PT'),
				'scan'    => Zend_Translate::LOCALE_DIRECTORY)
		);
		Zend_Validate_Abstract::setDefaultTranslator($translator);
	}

    protected function _initDbProfiler ()
    {

        $this->bootstrap('db');
        $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
        $profiler->setEnabled(true);
        $this->getPluginResource('db')->getDbAdapter()->setProfiler($profiler);
    }
    
    protected function _initLog()
    {
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writer);
        
        Zend_Registry::set('logger',$logger);
    }

    protected function _initViewHelpers ()
    {

        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->doctype("XHTML1_STRICT");
        $view1 = new Zend_View();
        $view1->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view1);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }


	/**
	 * used for handling top-level navigation
	 * @return Zend_Navigation
	 */
	protected function _initNavigation()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');

		$container = new Zend_Navigation($config);
		$view->navigation($container);

		$registry = Zend_Registry::getInstance();
		$registry->set('Zend_Navigation', $container);

		/*Zend_Controller_Action_HelperBroker::addHelper(
			new App_Controller_Action_Helper_Navigation()
		);*/
	}


    protected function _initRoutes ()
    {

        /**
         * 
         * @var unknown_type
         */
        $router = Zend_Controller_Front::getInstance()->getRouter();
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/espessura/:num', array(
            'controller' => 'ajax' , 
            'action' => 'espessura'));
        $router->addRoute('espessura', $route);
        /**
         * 
         * @var unknown_type
         */
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $route = new Zend_Controller_Router_Route('ajax/obraoptimus/:num', array(
            'controller' => 'ajax' , 
            'action' => 'obraoptimus'));
        $router->addRoute('obraoptimus', $route);
        /**
         * 
         * @var unknown_type
         */
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $route = new Zend_Controller_Router_Route('ajax/handleimages/*', array(
            'controller' => 'ajax' , 
            'action' => 'handleimages'));
        $router->addRoute('handleimages', $route);
        /**
         * 
         * @var unknown_type
         */
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $route = new Zend_Controller_Router_Route('ajax/deleteimages/*', array(
            'controller' => 'ajax' , 
            'action' => 'deleteimages'));
        $router->addRoute('deleteimages', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/registos/:codcliente', array(
            'controller' => 'ajax' , 
            'action' => 'registos'));
        $router->addRoute('registos', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/provaprepress/:id', array(
            'controller' => 'ajax' , 
            'action' => 'provaprepress'));
        $router->addRoute('provaprepress', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/provadeptec/:id', array(
            'controller' => 'ajax' , 
            'action' => 'provadeptec'));
        $router->addRoute('provadeptec', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/medidascortante/:id', array(
            'controller' => 'ajax' , 
            'action' => 'medidascortante'));
        $router->addRoute('medidascortante', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/getcortanteforview/:id', array(
            'controller' => 'ajax' , 
            'action' => 'getcortanteforview'));
        $router->addRoute('getcortanteforview', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('ajax/laboratorioname/:id', array(
            'controller' => 'ajax' , 
            'action' => 'laboratorioname'));
        $router->addRoute('laboratorioname', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('braille/braillepdf/:obra', array(
            'controller' => 'braille' , 
            'action' => 'braillepdf'));
        $router->addRoute('braille_createpdf', $route);
	    /**
	     *
	     * @var unknown_type
	     */
	    $route = new Zend_Controller_Router_Route('braille/braillepdfdownload/:obra', array(
		    'controller' => 'braille' ,
		    'action' => 'braillepdfdownload'));
	    $router->addRoute('braillepdfdownload', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('registos/edit/:id', array(
            'controller' => 'registos' , 
            'action' => 'edit'));
        $router->addRoute('editregistos', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('registos/update/:id', array(
            'controller' => 'registos' , 
            'action' => 'update'));
        $router->addRoute('updateregistos', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('registos/add/:id', array(
            'controller' => 'registos' , 
            'action' => 'add'));
        $router->addRoute('addregistos', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('arqchapas/editrecord/:codf3', array(
            'controller' => 'arqchapas' , 
            'action' => 'editrecord'));
        $router->addRoute('arqchapaseditrecord', $route);
	    /**
	     *
	     * @var unknown_type
	     */
	    /*$route = new Zend_Controller_Router_Route('arquivochapas/editrecord/:codf3', array(
		    'module'=>'default',
		    'controller' => 'arquivochapas' ,
		    'action' => 'editrecord'));
	    $router->addRoute('arquivochapas_edit', $route);*/
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('arqchapas/deleterecord/:id', array(
            'controller' => 'arqchapas' , 
            'action' => 'deleterecord'));
        $router->addRoute('arqchapasdeleterecord', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('registos/deleterecord/:id', array(
            'controller' => 'registos' , 
            'action' => 'deleterecord'));
        $router->addRoute('registosdeleterecord', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('registos/deleteproduct/:id', array(
            'controller' => 'registos' , 
            'action' => 'deleteproduct'));
        $router->addRoute('registosdeleteproduct', $route);
        /**
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('cliches/delete/:id', array(
            'controller' => 'cliches' , 
            'action' => 'delete'));
        $router->addRoute('clichesdelete', $route);
        /**
         * 
         */
        $route = new Zend_Controller_Router_Route('labs/view/*', array(
            'controller' => 'labs' , 
            'action' => 'view'));
        $router->addRoute('labsview', $route);
        /**
         * 
         */
        $route = new Zend_Controller_Router_Route('labs/new/:codf3', array(
            'controller' => 'labs' , 
            'action' => 'new'));
        $router->addRoute('labsnew', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('cockpit/preview/:obra', array(
            'controller' => 'cockpit' , 
            'action' => 'preview'));
        $router->addRoute('displayobra', $route);
        /**
         * 
         * @var unknown_type
         */
        $route = new Zend_Controller_Router_Route('labs/editrecord/:id', array(
            'controller' => 'labs' , 
            'action' => 'editrecord'));
        $router->addRoute('labseditrecord', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('labs/updaterecord/:id', array(
            'controller' => 'labs' , 
            'action' => 'updaterecord'));
        $router->addRoute('labsupdaterecord', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('labs/deleterecord/:id', array(
            'controller' => 'labs' , 
            'action' => 'deleterecord'));
        $router->addRoute('labsdeleterecord', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('labshome/edit/:id', array(
            'controller' => 'labshome' , 
            'action' => 'edit'));
        $router->addRoute('labshomeeditrecord', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('chapas/edit/:obra', array(
            'controller' => 'chapas' , 
            'action' => 'edit'));
        $router->addRoute('chapasrecedit', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('chapas/delete/:obra', array(
            'controller' => 'chapas' , 
            'action' => 'delete'));
        $router->addRoute('chapasrecdelete', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cliches/delete/:id', array(
            'controller' => 'cliches' , 
            'action' => 'delete'));
        $router->addRoute('clichesdelete', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cliches/edit/:id', array(
            'controller' => 'cliches' , 
            'action' => 'edit'));
        $router->addRoute('clichesedit', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cliches/update/:id', array(
            'controller' => 'cliches' , 
            'action' => 'update'));
        $router->addRoute('clichesupdate', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/display/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'display'));
        $router->addRoute('cortantesdisplay', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/edit/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'edit'));
        $router->addRoute('cortantesedit', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/search/*', array(
            'controller' => 'cortantes' , 
            'action' => 'search'));
        $router->addRoute('cortantessearch', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/update/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'update'));
        $router->addRoute('cortantesupdate', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/delete/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'delete'));
        $router->addRoute('cortantesdelete', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('cortantes/view/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'view'));
        $router->addRoute('cortantesview', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('producao/search/*', array(
            'controller' => 'producao' , 
            'action' => 'search'));
        $router->addRoute('producaosearch', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('entregas/search/*', array(
            'controller' => 'entregas' , 
            'action' => 'search'));
        $router->addRoute('entregassearch', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('emprova/search/*', array(
            'controller' => 'emprova' , 
            'action' => 'search'));
        $router->addRoute('emprovasearch', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('laetus/list/:cortante', array(
            'controller' => 'laetus' , 
            'action' => 'list'));
        $router->addRoute('laetuslist', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('laetus/delete/:id', array(
            'controller' => 'laetus' , 
            'action' => 'delete'));
        $router->addRoute('laetusdelete', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('laetus/editlaetussingleitem/:id', array(
            'controller' => 'laetus' , 
            'action' => 'editlaetussingleitem'));
        $router->addRoute('laetuseditlaetussingleitem', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('/cortantes/execedit/:id', array(
            'controller' => 'cortantes' , 
            'action' => 'execedit'));
        $router->addRoute('cortantesexecedititem', $route);
        /**
         * @var $route Ambiguous
         */
        $route = new Zend_Controller_Router_Route('/ajax/insertCortanteFolhaObra/*', array(
            'controller' => 'ajax' , 
            'action' => 'insertCortanteFolhaObra'));
        $router->addRoute('insertCortanteFolhaObraitem', $route);
        
        $route = new Zend_Controller_Router_Route('/cartolina/:id', array(
                'controller' => 'cartolina' ,
                'action' => 'index'));
        $router->addRoute('cartolina_index', $route);
        
        $route = new Zend_Controller_Router_Route('/obra/:id', array(
                'controller' => 'obra' ,
                'action' => 'index'));
        $router->addRoute('obra_index', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/edit/:id', array(
                'controller' => 'arqbraille' ,
                'action' => 'edit'));
        $router->addRoute('arqbraille_edit', $route);
        
        $route = new Zend_Controller_Router_Route('/ajax/txtbraille/:txt', array(
                'controller' => 'ajax' ,
                'action' => 'txtbraille'));
        $router->addRoute('ajax_txtbraille', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/editobra/:obra', array(
                'controller' => 'arqbraille' ,
                'action' => 'editobra'));
        $router->addRoute('arqbraille_editobra', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/replist/:id', array(
                'controller' => 'arqbraille' ,
                'action' => 'replist'));
        $router->addRoute('arqbraille_replist', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/renderpdf/*', array(
                'controller' => 'arqbraille' ,
                'action' => 'renderpdf'));
        $router->addRoute('arqbraille_renderpdf', $route);
        
        $route = new Zend_Controller_Router_Route('/braille/index/:id', array(
                'controller' => 'braille' ,
                'action' => 'index'));
        $router->addRoute('braille_index', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/thumb/:id', array(
                'controller' => 'arqbraille' ,
                'action' => 'thumb'));
        $router->addRoute('arqbraille_thumb', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/thumbtxt/:id', array(
                'controller' => 'arqbraille' ,
                'action' => 'thumbtxt'));
        $router->addRoute('arqbraille_thumbtxt', $route);
        
        $route = new Zend_Controller_Router_Route('/arqbraille/obrainfo/:id', array(
                'controller' => 'arqbraille' ,
                'action' => 'obrainfo'));
        $router->addRoute('arqbraille_obrainfo', $route);
        
         $route = new Zend_Controller_Router_Route('/ajax/getsizeofcarton/:job', array(
                'controller' => 'ajax' ,
                'action' => 'getsizeofcarton'));
        $router->addRoute('ajax_getsizeofcarton', $route);


        $route = new Zend_Controller_Router_Route('/webservices/certmail/:job', array(
                'controller' => 'webservices' ,
                'action' => 'certmail'));
        $router->addRoute('webservices_certmail', $route);


	    $route = new Zend_Controller_Router_Route('/codigolaetus/item/:id', array(
		    'controller' => 'codigolaetus' ,
		    'action' => 'item'));
	    $router->addRoute('codigolaetus_item_route', $route);


	    $route = new Zend_Controller_Router_Route('/chapasrecuperadas/edit/:obra', array(
		    'controller' => 'chapasrecuperadas' ,
		    'action' => 'edit'));
	    $router->addRoute('chapasrecuperadas_edit_route', $route);



	    $route = new Zend_Controller_Router_Route('/arquivochapas/editrecord/:codf3', array(
		    'controller' => 'arquivochapas' ,
		    'action' => 'editrecord'));
	    $router->addRoute('arquivochapas_editrecord_router', $route);

    }

    protected function _initAppAutoload ()
    {
        $moduleLoad = new Zend_Application_Module_Autoloader(array(
            'namespace' => '' , 
            'basePath' => APPLICATION_PATH));
    }

    protected function _initAutoload ()
    {

        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('App_');
        $loader->setFallbackAutoloader(true);
    }

    protected function _initDoctrine ()
    {

        $this->getApplication()->getAutoloader()->pushAutoloader(array(
            'Doctrine' , 
            'autoload'));
        spl_autoload_register(array(
            'Doctrine' , 
            'modelsAutoload'));
        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, DOctrine::MODEL_LOADING_CONSERVATIVE);
        $manager->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);
        $doctrineConfig = $this->getOption('doctrine');
        Doctrine::loadModels($doctrineConfig['models_path']);
        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        return $conn;
    }
}

