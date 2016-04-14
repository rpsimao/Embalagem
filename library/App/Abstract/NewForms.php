<?php

/**
 * Classe para definição dos formulários
 * 
 * @author Ricardo Simao
 * @version 2.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * Ultima revisao - 21/01/2010
 */
class App_Abstract_NewForms implements App_Interfaces_INewForms
{

    /**
     * Define os erros para apresentar ao utilizadores
     *
     */
    const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';

    const ERR_LENGHT_PASSWD = '* A palavra passe tem de ter entre 4 e 12 caracteres.';

    const ERR_COD_F3 = '* Este campo tem de ter 5 algarismos.';

    const ERR_EMAIL_MALFORMED = '* O endereço de email não é válido';

    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";

    /**
     * Define os estilos CSS para a form
     */
    const CLASS_BOX_TYPE_MINI = 'rounded-textbox_mini';

    const CLASS_BOX_TYPE_SMALL = 'rounded-textbox_small';

    const CLASS_BOX_TYPE_MEDIUM = 'rounded-textbox_medium';

    const CLASS_BOX_TYPE_LARGE = 'rounded-textbox_large';

    /**
     * Formulários.
     *
     * @var Zend_Form
     */
    protected $form;

    /**
     * Parametros para povoar o formulário
     * @var array
     */
    protected $params = array();

    /**
     * Define a action da form
     * @var string
     */
    protected $action;

    /**
     * Verifica se os valores que vêm do formulário são um array
     * @var mixed
     */
    protected $values;

    /**
     * Define o URL da acção
     * @param string $action
     * @return string
     */
    public function setAction ($action)
    {

        $this->action = $action;
    }

    /**
     * Retorna o URL da acção
     * @return string
     */
    protected function getAction ()
    {

        return $this->action;
    }

    /**
     * Constroi o formulário
     * É específico a cada classe
     */
    public function buildForm ()
    {
}

    /**
     * Mostra o formulário
     * @return Zend_Form
     */
    public function displayForm ()
    {

        $values = is_array($this->buildForm()) ? $this->buildForm() : array(
            $this->buildForm());
        $form = new Zend_Form();
        $form->setMethod('post');
        $form->setAction($this->getAction());
        $form->addElements($values);
        return $form;
    }

    /**
     * Mostra o formulário com povoamento de valores
     * @param array $params
     * @return Zend_Form
     */
    public function displayFormWithPopulate (array $params)
    {

        $form = $this->displayForm();
        $form->populate($params);
        return $form;
    }
}
?>