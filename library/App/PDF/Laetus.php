<?php

class App_PDF_Laetus
{

	/**
	 * @var App_User_Service_Laetus
	 */
	private $model;

	const BARRA_FINA = 2.83;

	const ESPACO = 5.67;

	const BARRA_GROSSA = 8.5;

	const ALTURA_BARRA = 17.01;

	const ESPACO_INICIAL_HORIZONTAL = 20;

	const ESPACO_INICIAL_VERTICAL = 50;

	const TRIANGULO = 17.01;

	const ESPACO_TRIANGULO = 45.36;

	const PDF_FILE = 'Template/laetusbase.pdf';

	public $espaco = NULL;


	public function __construct()
	{
		$this->model = new App_User_Service_Laetus();

	}


	private function getBarraFina ()
	{

		$barraFina = array(
			self::ESPACO_INICIAL_HORIZONTAL + self::ESPACO_TRIANGULO ,
			self::ESPACO_INICIAL_VERTICAL ,
			self::ESPACO_INICIAL_HORIZONTAL + self::ESPACO_TRIANGULO + self::BARRA_FINA ,
			self::ESPACO_INICIAL_VERTICAL + self::ALTURA_BARRA);
		return $barraFina;
	}

	private function getBarraGrossa ()
	{

		$barraFina = array(
			self::ESPACO_INICIAL_HORIZONTAL + self::ESPACO_TRIANGULO ,
			self::ESPACO_INICIAL_VERTICAL ,
			self::ESPACO_INICIAL_HORIZONTAL + self::ESPACO_TRIANGULO + self::BARRA_GROSSA ,
			self::ESPACO_INICIAL_VERTICAL + self::ALTURA_BARRA);
		return $barraFina;
	}

	private function getTriangulo ()
	{

		$triangulo = array(
			self::ESPACO_INICIAL_HORIZONTAL ,
			self::ESPACO_INICIAL_VERTICAL ,
			self::ESPACO_INICIAL_HORIZONTAL + self::TRIANGULO ,
			self::ESPACO_INICIAL_VERTICAL + self::TRIANGULO);
		return $triangulo;
	}

	public function setLaetusNumber ($number)
	{

		$this->number = $number;
	}

	private function getLaetusNumber ()
	{

		return $this->number;
	}

	public function calculateLaetus ()
	{

		$laetus = new App_Calculations_Laetus();
		$laetus->setValue($this->getLaetusNumber());
		$laetus->generateTempFile();
		$arguments = $laetus->dealWithNumber($laetus->getValue());
		return $laetus->handleNumbers($arguments);
	}

	public function setFormValues ($values)
	{
		$this->values = $values;
	}

	public function getFormValues ()
	{

		return $this->values;
	}


	private function getFormato($cortanteNumber)
	{


		$result = $this->model->getValue((int) $cortanteNumber);
		return $result['formato'];


	}

	public function drawBars ()
	{



		$values = $this->getFormValues();
		$sequence = $this->calculateLaetus();
		$barraFina = $this->getBarraFina();
		$barraGrossa = $this->getBarraGrossa();

		/**
		 * This function was added @July 2015. Don´t know why it start to add another value at the beginning of the array.
		 */
		array_shift($sequence);

		$pdf = Zend_Pdf::load(self::PDF_FILE);

			foreach ($sequence as $value) {
				if ($value == 1) {
					$pdf->pages[0]->drawRectangle($barraFina[0] + $this->espaco, $barraFina[1], $barraFina[2] + $this->espaco, $barraFina[3], Zend_Pdf_Page::SHAPE_DRAW_FILL);
					$this->espaco += self::BARRA_FINA + self::ESPACO;
				} else {
					$pdf->pages[0]->drawRectangle($barraGrossa[0] + $this->espaco, $barraGrossa[1], $barraGrossa[2] + $this->espaco, $barraGrossa[3], Zend_Pdf_Page::SHAPE_DRAW_FILL);
					$this->espaco += self::BARRA_GROSSA + self::ESPACO;
				}
			}

		$pdf->pages[0]->saveGS();
		$pdf->pages[0]->setStyle(App_PDF_FontStyles::bold(20));
		$pdf->pages[0]->drawText('Cortante Nº: ' . $values['cortante'], 80, 390, 'UTF-8');
		$pdf->pages[0]->restoreGS();
		$pdf->pages[0]->saveGS();
		$pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(14));
		$pdf->pages[0]->drawText('Formato: ' . $this->getFormato($values['cortante']), 390, 390, 'UTF-8');
		$pdf->pages[0]->drawText('Cliente: ' . $values['laboratorio'], 30, 330, 'UTF-8');
		$pdf->pages[0]->drawText('Produto: ' . $values['produto'], 30, 290, 'UTF-8');
		$pdf->pages[0]->drawText('Cód. F3: ' . $values['codf3'], 30, 250, 'UTF-8');
		$pdf->pages[0]->drawText('Cód. Laetus: ' . $this->getLaetusNumber(), 30, 100, 'UTF-8');
		$pdf->pages[0]->restoreGS();
		return $pdf;
	}

	public function checklaetusRender ()
	{

		$sequence = $this->calculateLaetus();
		$barraFina = $this->getBarraFina();
		$barraGrossa = $this->getBarraGrossa();

		/**
		 * This code was added @July 2015. Don´t know why it start to add another value at the beginning of the array.
		 */
		array_shift($sequence);




		$pdf = new Zend_Pdf();
		$pdf->pages[] = new Zend_Pdf_Page('280:120:');

			foreach ($sequence as $value) {
				if ($value == 1) {
					$pdf->pages[0]->drawRectangle($barraFina[0] + $this->espaco, $barraFina[1], $barraFina[2] + $this->espaco, $barraFina[3], Zend_Pdf_Page::SHAPE_DRAW_FILL);
					$this->espaco += self::BARRA_FINA + self::ESPACO;
				} else {
					$pdf->pages[0]->drawRectangle($barraGrossa[0] + $this->espaco, $barraGrossa[1], $barraGrossa[2] + $this->espaco, $barraGrossa[3], Zend_Pdf_Page::SHAPE_DRAW_FILL);
					$this->espaco += self::BARRA_GROSSA + self::ESPACO;
				}
			}

		$pdf->pages[0]->saveGS();
		$pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(14));
		$pdf->pages[0]->drawText('Laetus Nº: ' . $this->getLaetusNumber(), 25, 90, 'UTF-8');
		$pdf->pages[0]->restoreGS();
		return $pdf;
	}
}