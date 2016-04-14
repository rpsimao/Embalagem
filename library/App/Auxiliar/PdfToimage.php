<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 23/06/15
 * Time: 12:37
 */

class App_Auxiliar_PdfToimage {


	/**
	 * @param $file
	 */
	public function setPDFFile($file)
	{
		$this->file = $file;
	}

	/**
	 * @return mixed
	 */
	private function _getPDFFile()
	{
		return $this->file;
	}


	/**
	 * @param $type
	 */
	public function setImageType($type = "png")
	{
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	private function _getImageType()
	{
		return $this->type;
	}

	/**
	 * @param $type
	 */
	public function setImageSize($size)
	{
		$this->size = $size;
	}

	/**
	 * @return mixed
	 */
	private function _getImageSize()
	{
		return $this->size;
	}




	public function render($class = null){


		$im = new imagick($this->_getPDFFile());
		$im->setImageFormat($this->_getImageType());
		$im->thumbnailImage($this->_getImageSize(), 0);

		ob_start();
		echo $im;
		$contents = ob_get_contents();
		ob_end_clean();
		return '<img src="data:image/png;base64,' . base64_encode($contents) . '" class="'.$class.'"/>';



	}



}