<?php

class App_View_Helper_ArqBraillesSearchNav
{


    public $view;
    
    
    protected $form;

    /**
     */
    public function ArqBraillesSearchNav ()
    {
        $this->form = new App_Forms_ArqbraillesSearchByLab();
     ?>
       <script type="text/javascript" src="/js/arqbrailles/searchnav.js"></script>
        
        <div class="widget-box width-75" style="margin-left: auto;margin-right: auto">
		   <div class="widget-header"><h4 class="widget-title smaller"><i class="fa fa-search"></i> Arquivo Brailles Procura</h4>
		    <div class="widget-toolbar">
		      <div class="widget-menu">
		<a href="#" data-action="settings" data-toggle="dropdown">
			<i class="ace-icon fa fa-bars"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
			<li>
				<a href="/braille">Preço Brailles</a>
			</li>
			<li>
				<a href="/arqbraille">Listagem</a>
			</li>
			<li>
				<a href="/arqbraille/new">Criar Registo</a>
			</li>
			<li>
				<a href="/arqbraille/labs">Criar Laboratório</a>
			</li>
			<li>
				<a href="/arqbraille/selo">Criar Selo</a>
			</li>
			<li>
				<a href="/braille/femea">Criar Fêmea</a>
			</li>
			<li>
				<a href="/braille/prova">Criar Braille Prova</a>
			</li>
	</div>

   <a data-action="collapse" href="#"><i class="ace-icon fa fa-chevron-up"></i></a>
   <a data-action="close" href="#"><i class="ace-icon fa fa-times"></i></a>
 </div>
</div>

    <div class="widget-body">

        <div class="widget-main">
            <div id="Arq-Brailles-Search-By-Lab-Div">

	            <div class="row">
					<div class="col-xs-4">
						<form class="form-inline" action="/arqbraille/searchobra" method="post" onsubmit="return validateInput('job')">
							<input type="text" class="form-control search-query input-small" placeholder="Procurar Obra" id="job" name="job"/>
								<button class="btn btn-default btn-sm">
									<i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
								</button>
						</form>
					</div>
					<div class="col-xs-4">
						<form class="form-inline" action="/arqbraille/searchbraille" method="post" onsubmit="return validateInput('braille')">

									<input type="text" class="form-control search-query input-small" placeholder="Procurar Braille" id="braille" name="braille"/>
							<button class="btn btn-default btn-sm">
								<i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
							</button>

						</form>
					</div>

		            <div class="col-xs-4">
			            <form class="form-inline" action="/arqbraille/searchtxt" method="post" onsubmit="return validateInput('txt')">

					            <input type="text" class="form-control search-query input-small" placeholder="Procurar Texto" id="txt" name="txt"/>
					            <button class="btn btn-default btn-sm">
						            <i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
					            </button>

			            </form>
		            </div>

				</div>
				<div class="space-4"></div>
		        <div class="row">
			        <div class="col-xs-4">
				        <form class="form-inline" action="/arqbraille/searchlab" method="post" onsubmit="return validateInput('labs')">


						        <?php echo $this->form->getElement('labs')->setDecorators(array('ViewHelper'))?>
						        <button class="btn btn-default btn-sm">
							        <i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
						        </button>

				        </form>
			        </div>
			        <div class="col-xs-4">
				        <form class="form-inline" action="/arqbraille/searchcodigocliente" method="post" onsubmit="return validateInput('codcli')">

					        <input type="text" class="form-control search-query input-small" placeholder="Procurar Cód. Cliente" id="codcli" name="codcli"/>
						        <button class="btn btn-default btn-sm">
							        <i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
						        </button>

				        </form>
			        </div>
			        <div class="col-xs-4">
				        <form class="form-inline" action="/arqbraille/searchcodif3" method="post" onsubmit="return validateInput('codf3')">

						        <input type="text" class="form-control search-query input-small" placeholder="Procurar Cód. F3" id="codf3" name="codf3"/>
						        <button class="btn btn-default btn-sm">
							        <i class="ace-icon fa fa-search  align-top bigger-125 icon-on-right"></i>
						        </button>

				        </form>
			        </div>

		        </div>

            </div>
		</div>
	</div>
  </div>
 </div>




    <?php


    }

    /**
     * Sets the view field
     *
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}