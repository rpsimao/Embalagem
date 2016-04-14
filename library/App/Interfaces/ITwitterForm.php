<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 20/06/14
 * Time: 15:11
 */

interface App_Interfaces_ITwitterForm {

	/**
	 * Define os erros para apresentar ao utilizadores
	 *
	 */
	const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';
	const ERR_LENGHT_PASSWD = '* A palavra passe tem de ter entre 4 e 12 caracteres.';
	const ERR_COD_F3 = '* Este campo tem de ter entre 5 e 7 algarismos.';
	const ERR_EMAIL_MALFORMED = '* O endereço de email não é válido';
	const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";


}

 