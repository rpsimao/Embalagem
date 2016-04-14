<?php
/**
 * Classe Para criar imagens
 *
 * @author Ricardo Simao
 * @version 1.2
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * @date 20/06/2014
 */
class App_Auxiliar_CreateImage
{

    private $numberOfLines;
	private $numberOfParagraphs;
	private $numberOfChars;

	/**
	 * @param mixed $numberOfChars
	 */
	public function setNumberOfChars($numberOfChars)
	{
		$this->numberOfChars = $numberOfChars;
	}

	/**
	 * @return mixed
	 */
	public function getNumberOfChars()
	{
		return $this->numberOfChars;
	}

	/**
	 * @param mixed $numberOfLines
	 */
	public function setNumberOfLines($numberOfLines)
	{
		$this->numberOfLines = $numberOfLines;
	}

	/**
	 * @return mixed
	 */
	public function getNumberOfLines()
	{
		for ($index = 0; $index < $this->numberOfLines; $index ++) {
			$numberOfLines[] = $index;
		}

		return $numberOfLines;
	}

	/**
	 * @param mixed $numberOfParagraphs
	 */
	public function setNumberOfParagraphs($numberOfParagraphs)
	{
		$this->numberOfParagraphs = $numberOfParagraphs;
	}

	/**
	 * @return mixed
	 */
	public function getNumberOfParagraphs()
	{
		return $this->numberOfParagraphs;
	}

	/**
     * Define quantos caracters tem a maior linha do texto
     * @param int $width
     * @return int
     */
    public function setChars ($width)
    {

        return $this->chars = $width;
    }

    /**
     * baseado no numero de caracters retorna a largura da imagem
     * @return int
     */
    private Function getWidth ()
    {

        if ($this->chars <= 5) {
            return 160;
        } elseif ($this->chars > 5 && $this->chars <= 10) {
            return 300;
        } else {
            return 550;
        }
    }

    /**
     * Define o txto para a imagem
     * @param string $text
     * @return string
     */
    public function setText ($text)
    {

        return $this->text = $text;
    }

    /**
     * Retorna o texto para a imagem
     * @return string
     */
    private function getText ()
    {

        return $this->text;
    }

    /**
     * Define se o texto é para Braille
     * @param bol $flag
     * @return bolean
     */
    public function setBrailleFlag ($flag)
    {

        return $this->flag = $flag;
    }

    /**
     * Retorna o valor se o texto é para Braille
     * @return boolean
     */
    private function getflag ()
    {

        return $this->setBrailleFlag($this->flag);
    }

    /**
     * Define o array do texto para a imagem
     * @param mixed $input
     * @return mixed
     */
    public function setArrayOfText (array $input)
    {

        return $this->input = $input;
    }

    /**
     * Define a altura da imagem baseado no número de linhas
     * @return integer
     */
    private function setImageHeight ()
    {

        if (is_array($this->input)) {
            $numberOfLines = count($this->input);

            $start = 50;

            $finish = $numberOfLines * $start;

            return $finish;

           /** switch ($numberOfLines) {
                case 1:
                    return 50;
                    break;
                case 2:
                    return 100;
                    break;
                case 3:
                    return 150;
                    break;
                case 4:
                    return 200;
                    break;
                case 5:
                    return 250;
                    break;
                case 6:
                    return 300;
                    break;
                case 7:
                    return 350;
                    break;
                case 8:
                    return 400;
                    break;
                case 9:
                    return 450;
                    break;
                case 10:
                    return 500;
                    break;
                case 11:
                    return 550;
                    break;
                case 12:
                    return 600;
                    break;
                case 13:
                    return 650;
                    break;
                case 14:
                    return 700;
                    break;
                case 15:
                    return 750;
                    break;
                case 16:
                    return 800;
                    break;
                default:
                    return 1000;
                    break;
            }*/
        } else {
            return 200;
        }
    }

    /**
     * Baseado na flag define o tipo de letra a utilizar
     * @return string
     */

    private function setFont ()
    {

        switch ($this->getflag()) {
            case TRUE:
                $font = "fonts/braille.ttf";
                return $font;
        }
    }

    /**
     * Cria a imagem
     * @return image
     */
    private function create ()
    {

        $image = imagecreatetruecolor($this->getWidth(), $this->setImageHeight());
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $white);
        $string = $this->getText();
        imagettftext($image, 30, 0, 30, 30, $black, $this->setFont(), $string);
        return $image;
    }

    /**
     * Renderiza a imagem para o browser
     * @param string class define the CSS class for the image
     * @return string
     */
    public function render ($class = null)
    {

        // start buffering
        ob_start();
        imagepng($this->create());
        $contents = ob_get_contents();
        ob_end_clean();
        return '<img src="data:image/png;base64,' . base64_encode($contents) . '" class="'.$class.'"/>';
        imagedestroy($this->create());
        
    }

	public function renderbase64(){

		ob_start();
		imagepng($this->create());
		$contents = ob_get_contents();
		ob_end_clean();
		$base64 = base64_encode($contents);
		imagedestroy($this->create());

		return $base64;

	}
}