<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 27/05/14
 * Time: 11:20
 */

class App_View_Helper_LeftBar extends Zend_View_Helper_Abstract{


	/**
	 *
	 */
	public function LeftBar()
	{
?>
		<div id="sidebar" class="sidebar responsive">
		<script type="text/javascript">
			try{ace.settings.check("sidebar" , "fixed")}catch(e){}
		</script>

		<!--
		<div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
				<button class="btn btn-success">
					<i class="ace-icon fa fa-signal"></i>
				</button>

				<button class="btn btn-info">
					<i class="ace-icon fa fa-pencil"></i>
				</button>

				<!-- #section:basics/sidebar.layout.shortcuts -->
				<!--
				<button class="btn btn-warning">
					<i class="ace-icon fa fa-users"></i>
				</button>

				<button class="btn btn-danger">
					<i class="ace-icon fa fa-cogs"></i>
				</button>

				<!-- /section:basics/sidebar.layout.shortcuts -->
			<!-- </div>

			<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
				<span class="btn btn-success"></span>

				<span class="btn btn-info"></span>

				<span class="btn btn-warning"></span>

				<span class="btn btn-danger"></span>
			</div>
		</div><!-- /.sidebar-shortcuts -->

		<ul class="nav nav-list">
			<li class="<?=$this->_setActive("index") ?>">
				<a href="<?=$this->_getURL("home") ?>">
					<i class="menu-icon fa fa-home"></i>
					<span class="menu-text"> Home </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="">
					<i class="menu-icon fa fa-list-alt"></i>
					<span class="menu-text"> Selo </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("braille")?> hover">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-braille"></i>
					<span class="menu-text"> Braille </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<li class="">
						<a href="<?=$this->_getURL("braille")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Braille
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?=$this->_getURL("braille_prova")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Braille Prova
						</a>
						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			<li class="<?=$this->_setActive("arqbraille")?> hover">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-archive"></i>
					<span class="menu-text"> Arquivo Braille </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<li class="">
						<a href="<?=$this->_getURL("arqbraille_listagem")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Listagem Braille
						</a>
						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="<?=$this->_getURL("arqbraille_new")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Registo
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?=$this->_getURL("arqbraille_selo")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Selo
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="<?=$this->_getURL("arqbraille_labs")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Laboratório
						</a>
						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="<?=$this->_getURL("arqbraille_pricesimulation")?>">
							<i class="menu-icon fa fa-caret-right"></i>
							Simular Preço
						</a>
						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			<li class="<?=$this->_setActive("codigolaetus")?> hover">


				<a href="/codigolaetus" class="dropdown-toggle">
					<i class="menu-icon fa fa-align-justify fa-rotate-90"></i>
					<span class="menu-text"> Código Laetus </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>
				<b class="arrow"></b>
				<ul class="submenu">
					<li class="">
						<a href="/codigolaetus">
							<i class="menu-icon fa fa-caret-right"></i>
							Criar Laetus
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="/codigolaetus/check">
							<i class="menu-icon fa fa-caret-right"></i>
							Verificar Laetus
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="/codigolaetus/recreatelaetus">
							<i class="menu-icon fa fa-caret-right"></i>
							Regenerar Laetus
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="/codigolaetus/edit">
							<i class="menu-icon fa fa-caret-right"></i>
							Editar Laetus
						</a>
						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="/codigolaetus/listsearch">
							<i class="menu-icon fa fa-caret-right"></i>
							Listagem
						</a>
						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			<li class="<?=$this->_setActive("diecuts")?>  hover">
				<a href="/diecuts">
					<i class="menu-icon fa fa-square-o"></i>
					<span class="menu-text"> Cortantes </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="/cockpit">
					<i class="menu-icon fa fa-table"></i>
					<span class="menu-text"> Obras </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="/tolerancias">
					<i class="menu-icon fa fa-file-text-o"></i>
					<span class="menu-text"> Tolerâncias </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="/labs">
					<i class="menu-icon fa fa-hdd-o"></i>
					<span class="menu-text"> Registos </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("arquivochapas")?> hover">
				<a href="/arquivochapas">
					<i class="menu-icon fa fa-inbox"></i>
					<span class="menu-text"> Arq. de Chapas </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("chapasrecuperadas")?> hover">
				<a href="/chapasrecuperadas">
					<i class="menu-icon fa fa-recycle"></i>
					<span class="menu-text"> Chapas Recup. </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("labs")?> hover">
				<a href="/labshome">
					<i class="menu-icon fa fa-flask"></i>
					<span class="menu-text"> Laboratorios </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="/cliches">
					<i class="menu-icon fa fa-picture-o"></i>
					<span class="menu-text"> Clichés </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("producao")?> hover">
				<a href="/producao">
					<i class="menu-icon fa fa-dashboard"></i>
					<span class="menu-text"> Produção </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class=" hover">
				<a href="/entregas">
					<i class="menu-icon fa fa-truck"></i>
					<span class="menu-text"> Entregas </span>
				</a>
				<b class="arrow"></b>
			</li>
			<li class="<?=$this->_setActive("config")?> hover">
				<a href="/config">
					<i class="menu-icon fa fa-cogs"></i>
					<span class="menu-text"> Configurações </span>
				</a>
				<b class="arrow"></b>
			</li>
		</ul><!-- /.nav-list -->

		<!-- #section:basics/sidebar.layout.minimize -->
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
		</div>

		<!-- /section:basics/sidebar.layout.minimize -->
		<script type="text/javascript">
			try{ace.settings.check("sidebar" , "collapsed")}catch(e){}
		</script>
	</div>


<?php
	}


	/**
	 * @param $controller
	 * @return string
	 * @throws Zend_Exception
	 */
	private function _setActive($controller)
	{

		$navigation = Zend_Registry::get('Zend_Navigation');
		$request    = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();

		$y = $navigation->findBy('controller', $controller)->get("controller");

		$active = ($request === $y) ? " active " : "";

		return $active;

	}


	/**
	 * Get the URL from navigation based on the ID
	 * @param $nameOfID
	 * @return mixed
	 * @throws Zend_Exception
	 */
	private function _getURL($nameOfID)
	{
		$config = Zend_Registry::get('Zend_Navigation');

		$uri = $config->findBy('id', $nameOfID)->get("uri");

		return $uri;

	}


	/**
	 * @param $liTag
	 * @return string
	 * @deprecated
	 */

	private function _defineActive($liTag)
	{

		$request    = Zend_Controller_Front::getInstance()->getRequest();

		$controller = $request->getControllerName();
		//$action     = $request->getActionName();
		//$param      = $request->getParam("date");



		if ($liTag == "default" && $controller == "default")
		{
			return "active";
		}

		if ($liTag == "arqbraille" && $controller == "arqbraille")
		{
			return "active";
		}

		if ($liTag == "codigolaetus" && $controller == "codigolaetus")
		{
			return "active";
		}

		if ($liTag == "diecuts" && $controller == "diecuts")
		{
			return "active";
		}

		if ($liTag == "cockpit" && $controller == "cockpit")
		{
			return "active";
		}

		if ($liTag == "tolerancias" && $controller == "tolerancias")
		{
			return "active";
		}

		if ($liTag == "labs" && $controller == "labs")
		{
			return "active";
		}

		if ($liTag == "arquivochapas" && $controller == "arquivochapas")
		{
			return "active";
		}

		if ($liTag == "chapasrecuperadas" && $controller == "chapasrecuperadas")
		{
			return "active";
		}

		if ($liTag == "labshome" && $controller == "labshome")
		{
			return "active";
		}

		if ($liTag == "cliches" && $controller == "cliches")
		{
			return "active";
		}

		if ($liTag == "producao" && $controller == "producao")
		{
			return "active";
		}

		if ($liTag == "entregas" && $controller == "entregas")
		{
			return "active";
		}

		if ($liTag == "caixas" && $controller == "caixas")
		{
			return "active";
		}


	}

} 