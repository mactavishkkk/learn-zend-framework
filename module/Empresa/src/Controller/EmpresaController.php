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
        return new ViewModel(['empresas' => $this->table->getAll()]);
    }

    public function adicionarAction()
    {
        $form = new EmpresaForm();
        $form->get('submit')->setValue('Adicionar');
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
        $form->get('submit')->setAttribute('value', 'Salvar');
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
            $del = $request->getPost('del', 'CANCELAR');
            
            if ($del === 'REMOVER') {
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
