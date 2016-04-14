<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 28/05/14
 * Time: 14:57
 */

class App_view_Helper_PrecoBrailleMacho extends Zend_View_Helper_Abstract {


	public function PrecoBrailleMacho()
	{

		$request = Zend_Controller_Front::getInstance()->getRequest();

		$controller = $request->getControllerName();

		if ($controller == "arqbraille" || $controller == "braille"): ?>

			<div class="nav-search" id="nav-search">
				<ul class="list-inline">
					<li class="text-primary"><i class="fa fa-caret-right"></i>&nbsp;Pre&ccedil;o Braille Macho:</li>
					<li><i class="fa fa-euro"></i>&nbsp;<span id="braille_male_price"></span></li>
					<li>
						<span id="braille_male_price_button_place">
							<button id="braille_male_price_button" class="btn btn-minier btn-default" onclick="changePrice()"><i class="fa fa-repeat"></i>&nbsp;Alterar</button>
						</span>
					</li>
				</ul>
			</div>

<?php endif;
	}

}


