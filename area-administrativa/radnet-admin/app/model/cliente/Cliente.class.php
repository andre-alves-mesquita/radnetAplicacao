<?php

/**
 * Customer Active Record
 * @author  <your-name-here>
 */
class Cliente extends TRecord
{
    const TABLENAME = 'cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY =  'max'; // {max, serial}

    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('cpf');
        parent::addAttribute('rg');
        parent::addAttribute('dt_nasc');
        parent::addAttribute('nome_mae');
        parent::addAttribute('email');
        parent::addAttribute('tel_1');
        parent::addAttribute('tel_2');
        parent::addAttribute('endereco');
        parent::addAttribute('ponto_referencia');
        parent::addAttribute('data_vencimento');
        parent::addAttribute('plano_escolhido');
        parent::addAttribute('info_add');
        parent::addAttribute('nome_func');
    }
}
