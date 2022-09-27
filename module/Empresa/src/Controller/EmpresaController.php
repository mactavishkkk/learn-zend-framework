<?php

namespace Empresa\Controller;

use Empresa\Form\EmpresaForm;
use Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EmpresaController extends AbstractActionController
{

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $paginator = $this->table->fetchAll(true);

        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        $paginator->setItemCountPerPage(15);

        return new ViewModel(['paginator' => $paginator]);
    }

    public function adicionarAction()
    {
        $form = new EmpresaForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel(['form' => $form]);
        }

        $empresa = new \Empresa\Model\Empresa();
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return new ViewModel(['form' => $form]);
        }

        $empresa->exchangeArray($form->getData());
        $this->table->salvarEmpresa($empresa);
        return $this->redirect()->toRoute('empresa');
    }

    public function editarAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id === 0) {
            return $this->redirect()->toRoute('empresa', ['action' => 'adicionar']);
        }

        try {
            $empresa = $this->table->getEmpresa($id);
        } catch (Exception $exc) {
            return $this->redirect()->toRoute('empresa', ['action' => 'index']);
        }

        $form = new EmpresaForm();
        $form->bind($empresa);
        $form->get('submit')->setAttribute('value', 'Save');
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        //$empresa->exchangeArray($form->getData());
        $this->table->salvarEmpresa($form->getData());
        return $this->redirect()->toRoute('empresa');
    }

    public function removerAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id === 0) {
            return $this->redirect()->toRoute('empresa');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Delete');
            
            if ($del === 'Delete') {
                $id = (int) $request->getPost('id');
                $this->table->deletarEmpresa($id);
            }

            return $this->redirect()->toRoute('empresa');
        }

        return ['id' => $id, 'empresa' => $this->table->getEmpresa($id)];
    }

    /* 
        ../empresa -> index
        ../empresa/adicionar -> adicionarAction
        ../empresa/editar/:id -> editarAction
        ../empresa/remover/:id -> removerAction
    */
}
