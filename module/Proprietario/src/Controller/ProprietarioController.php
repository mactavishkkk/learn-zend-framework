<?php

namespace Proprietario\Controller;

use Proprietario\Form\ProprietarioForm;
use Proprietario\Model\Proprietario;
use Proprietario\Model\ProprietarioTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProprietarioController extends AbstractActionController
{
    private $table;

    public function __construct(ProprietarioTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'proprietarios' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new ProprietarioForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $proprietario = new Proprietario();
        $form->setInputFilter($proprietario->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $proprietario->exchangeArray($form->getData());
        $this->table->saveProprietario($proprietario);
        return $this->redirect()->toRoute('proprietario');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('proprietario', ['action' => 'add']);
        }

        try {
            $proprietario = $this->table->getProprietario($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('proprietario', ['action' => 'index']);
        }

        $form = new ProprietarioForm();
        $form->bind($proprietario);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($proprietario->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->table->saveProprietario($proprietario);

        return $this->redirect()->toRoute('proprietario', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('proprietario');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Cancel');

            if($del == 'Delete') {
                $id = (int) $request->getPost('id');
                $this->table->deleteProprietario($id);
            }

            return $this->redirect()->toRoute('proprietario');
        }

        return [
            'id' => $id,
            'proprietario' => $this->table->getProprietario($id),
        ];
    }
}
