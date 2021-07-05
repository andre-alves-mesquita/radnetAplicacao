<?php

use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridActionGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Widget\Form\TDate;

/**
 * DatagridBootstrapView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     André Alves Mesquita
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class RegistroClienteExterno extends TPage
{
    private $datagrid;
    private $loaded;
    private $pageNavigation;

    public function __construct()
    {
        parent::__construct();

        if (empty($_REQUEST['page'])) {
            $_REQUEST['page'] = 1;
            $_REQUEST['offset'] = 0;
        }

        // creates one datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);

        // create the datagrid columns
        $id       = new TDataGridColumn('id',    'Id',    'center', '5%');
        $nome       = new TDataGridColumn('nome',    'Nome',    'center', '20%');
        $cpf       = new TDataGridColumn('cpf',    'Cpf',    'left', '15%');
        $dt_nasc      = new TDataGridColumn('dt_nasc',   'Data de Nascimento',   'left', '20%');
        $dt_nasc->setTransformer(array($this, 'setDatebr'));
        $email      = new TDataGridColumn('email',   'E-Mail',   'left', '20%');
        $tel_1      = new TDataGridColumn('tel_1',   'Telefone',   'left', '20%');
        $tel_1->setTransformer(array($this, 'setNumber'));

        // add the columns to the datagrid, with actions on column titles, passing parameters
        $this->datagrid->addColumn($id,   new TAction([$this, 'onColumn'], ['column' => 'id']));
        $this->datagrid->addColumn($nome,   new TAction([$this, 'onColumn'], ['column' => 'nome']));
        $this->datagrid->addColumn($cpf,   new TAction([$this, 'onColumn'], ['column' => 'cpf']));
        $this->datagrid->addColumn($dt_nasc,  new TAction([$this, 'onColumn'], ['column' => 'dt_nasc']));
        $this->datagrid->addColumn($email,  new TAction([$this, 'onColumn'], ['column' => 'email']));
        $this->datagrid->addColumn($tel_1,  new TAction([$this, 'onColumn'], ['column' => 'tel_1']));

        //seting mask

        $order1 = new TAction(array($this, 'onReload'));
        $order2 = new TAction(array($this, 'onReload'));

        $order1->setParameter('order', 'id');
        $order2->setParameter('order', 'nome');

        $id->setAction($order1);
        $nome->setAction($order2);


        // creates two datagrid actions
        $action1 = new TDataGridAction([$this, 'onView'],   [
            'id' => '{id}',
            'nome' => '{nome}',
            'cpf' => '{cpf}',
            'rg' => '{rg}',
            'dt_nasc' => '{dt_nasc}',
            'email' => '{email}',
            'tel_1' => '{tel_1}',
            'tel_2' => '{tel_2}',
            'endereco' => '{endereco}',
            'ponto_referencia' => '{ponto_referencia}',
            'data_vencimento' => '{data_vencimento}',
            'plano_escolhido' => '{plano_escolhido}',
            'info_add' => '{info_add}',
            'nome_func' => '{nome_func}'
        ]);


        $action2 = new TDataGridAction([$this, 'onDelete'],   ['id' => '{id}']);

        $action1->setLabel('Visualizar');
        $action1->setImage('fa:search #7C93CF');
        $action2->setLabel('Deletar');
        $action2->setImage('far:trash-alt red');

        $action_group = new TDataGridActionGroup('Actions ', 'fa:th');
        $action_group->addHeader('Ações Disponíveis');
        $action_group->addAction($action1);
        $action_group->addAction($action2);

        // add the actions to the datagrid
        $this->datagrid->addActionGroup($action_group);

        // creates the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup('Datagrid Clientes Cadastrados');
        $panel->add($this->datagrid)->style = 'overflow-x:auto';
        //$panel->addFooter('footer');

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        //$vbox->add($panel);
        parent::add($vbox);
    }

    /**
     * Load the data into the datagrid
     */


    function onColumn($param)
    {

        new TMessage('info', "Coluna {$param['column']}");
    }

    function onReload($param = null)
    {
        try {


            TTransaction::open('radnet');
            $repository = new TRepository('Cliente');
            $limit = 10;

            $criteria = new TCriteria;
            $criteria->setProperties($param);
            $criteria->setProperty('limit', $limit);

            $objects = $repository->load($criteria);


            $this->datagrid->clear();

            if ($objects) {
                foreach ($objects as $object) {
                    $this->datagrid->addItem($object);
                }
            }


            $criteria->resetProperties();


            $count = $repository->count($criteria);



            $this->pageNavigation->setCount($count);
            $this->pageNavigation->setProperties($param);
            $this->pageNavigation->setLimit($limit);

            TTransaction::close();
            $this->loaded = true;
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Executed when the user clicks at the view button
     */
    public function onView($param)
    {


        // get the parameter and shows the message
        $id = $param['id'];
        $nome = $param['nome'];
        $cpf = $param['cpf'];
        $rg = $param['rg'];
        $dt_nasc = $this->formatarDataBr($param['dt_nasc']);
        $email = $param['email'];
        $tel_1 = $this->formatarNumTel($param['tel_1']);
        $tel_2 = $this->formatarNumTel($param['tel_2']);
        $endereco = $param['endereco'];
        $ponto_referencia = $param['ponto_referencia'];
        $data_vencimento = $param['data_vencimento'];
        $plano_escolhido = $param['plano_escolhido'];
        $info_add = $param['info_add'];
        $nome_func = $param['nome_func'];

        new TMessage('info', "
        <div style='text-align:left; width:400px;'>

        <table  >
        <tr>
        <td><font color=red>Id: </font><b>$id</b> </td><td> <font color=red>Nome: </font><b>$nome</b> </td>
        </tr> 
       <tr>
        <td><font color=red> Cpf: </font><b>$cpf</b></td><td> <font color=red>Rg: </font><b>$rg</b></td>
       </tr>
       <tr>
        <td><font color=red>Dt Nasc: </font><b>$dt_nasc</b></td> <td><font color=red>Email: </font><b>$email</b></td>
       </tr>
       <tr>
       <td><font color=red>Telefone: </font><b>$tel_1</b></td><td> <font color=red>Telefone 2ª Opção: </font><b>$tel_2</b></td>
       </tr>
       <tr>
<td>     <font color=red>Endereço: </font><b>$endereco</b></td><td>  <font color=red>Ponto de Referencia: </font><b>$ponto_referencia</b></td>
       </tr>

       <tr>

<td>  <font color=red>Data de Vencimento: </font><b>$data_vencimento</b></td><td> <font color=red>Plano Escolhido: </font><b>$plano_escolhido</b></td>
       </tr>
       <tr>
<td>   <font color=red>Info Add: </font><b>$info_add</b></td><td>     <font color=red>Nome Funcionario: </font><b>$nome_func</b></td>
       </tr>
         
        </div>
        ");



        $param = array();
        $param['page'] = $_REQUEST['page'];
        $param['offset'] = $_REQUEST['offset'];

        $this->onReload($param);
    }


    public function setDatebr($data, $obj)
    {
        $dt = new DateTime($data);
        return $dt->format('d/m/Y');
    }

    function formatarDataBr($param)
    {

        if ($param) {
            // get the date parts
            $year = substr($param, 0, 4);
            $mon  = substr($param, 5, 2);
            $day  = substr($param, 8, 2);
            return "{$day}/{$mon}/{$year}";
        }
    }

    public function setNumber($data, $obj)
    {

        $ddd = substr($data, 0, 2);
        $num1  = substr($data, 3, 5);
        $num2  = substr($data, 9, 4);
        return "({$ddd}) {$num1} - {$num2}";
    }

    function onDelete($param)
    {

        $key = $param['key'];
        $actionDeletar = new TAction(array($this, 'Delete'));

        $param = array();
        $param['page'] = $_REQUEST['page'];
        $param['offset'] = $_REQUEST['offset'];

        $actionDeletar->setParameter('key', $key);
        $actionDeletar->setParameter('offset', $_REQUEST['offset']);
        $actionDeletar->setParameter('page', $_REQUEST['page']);

        new TQuestion('Deseja excluir o registro?', $actionDeletar);



        $this->onReload($param);
    }

    function Delete($param)
    {


        try {

            $key = $param['key'];

            TTransaction::open('radnet'); // open transaction 
            $cliente = new Cliente($key);
            $cliente->delete(); // delete object
            TTransaction::close(); // close transaction

            //$this->onReload();

            new TMessage('info', 'Registro deletado com sucesso');
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback(); // undo all pending operations


        }




        $param['page'] = $_REQUEST['page'];
        $param['offset'] = $param['offset'];

        $this->onReload($param);
    }

    /**
     * shows the page
     */
    function show()
    {

        if (!$this->loaded) {
            $this->onReload();
        }
        parent::show();
    }


    function formatarNumTel($param)
    {
        // get the date parts
        $ddd = substr($param, 0, 2);
        $num1  = substr($param, 3, 5);
        $num2  = substr($param, 9, 4);
        return "({$ddd}) {$num1} - {$num2}";
    }
}
