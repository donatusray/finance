<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 09/02/2024
 * Time: 23:20
 */

namespace App\Controllers;


use App\Models\CategoryModel;

class Categories extends BaseController
{

    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $queryString = $_SERVER['QUERY_STRING'];
        session()->set('current_page', base_url('categories') . "?" . $queryString);

        $parents = (isset($_GET['parents']) or $_GET['parents'] != '') ? $_GET['parents'] : 0;
        $type = (isset($_GET['tipe']) or $_GET['tipe'] != '') ? $_GET['tipe'] : '';
        $listCategory = $this->categoryModel->listCategoryFilter($type, $parents);
        $listCategoryParent = $this->categoryModel->listCategoryParent();
        $data['parents'] = $listCategoryParent;
        $data['categories'] = $listCategory;
        return view('list/category_list', $data);
    }

    public function add()
    {
        $listCategoryParent = $this->categoryModel->listCategoryParent();
        $data['parents'] = $listCategoryParent;
        return view('forms/category_add', $data);
    }

    public function insert()
    {
        $parent = $this->request->getPost('category_parent_id');
        $data = array(
            'category_name' => $this->request->getPost('category_name'),
            'category_type' => $this->request->getPost('category_type'),
            'category_description' => $this->request->getPost('category_description'),
            'category_parent_id' => $parent,
            'category_parent_name' => ($parent == 0) ? '' : $this->request->getPost('category_parent_name'),
            'createdby' => 1,
            'updatedby' => 1
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('categories/add'));
        } else {
            $simpan = $this->categoryModel->insertCategory($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Insert Kategori Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $category = $this->categoryModel->getCategory($id);
        $categoryParent = $this->categoryModel->listCategoryParent();
        $data['category'] = $category;
        $data['parents'] = $categoryParent;
        session()->setFlashdata('inputs', $category);
        return view('forms/category_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('category_id');
        $parent = $this->request->getPost('category_parent_id');
        $data = array(
            'category_name' => $this->request->getPost('category_name'),
            'category_type' => $this->request->getPost('category_type'),
            'category_description' => $this->request->getPost('category_description'),
            'updatedby' => 1,
            'updated' => date('Y-m-d h:i:s'),
            'category_parent_id' => $parent,
            'category_parent_name' => ($parent == 0) ? '' : $this->request->getPost('category_parent_name'),
        );

        $dataErrors = $this->getError($data);

        if (!empty($dataErrors)) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $dataErrors);
            return redirect()->to(base_url('categories/edit') . "?id=" . $id);
        } else {
            $simpan = $this->categoryModel->updateCategory($data, $id);
            if ($simpan) {
                session()->setFlashdata('success', 'Update Kategori Berhasil');
                return redirect()->to(session()->get('current_page'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');

        $delete = $this->categoryModel->deleteCategory($id);
        if ($delete) {
            session()->setFlashdata('success', 'Delete Kategori Berhasil');
            return redirect()->to(session()->get('current_page'));
        } else {
            session()->setFlashdata('warning', 'Delete Kategori Gagal');
            return redirect()->to(session()->get('current_page'));
        }

    }


    private function getError($post)
    {
        $error = array();
        if ($post['category_name'] == "") {
            $error[] = "Nama Kategori Wajib Diisi";
        }
        if ($post['category_type'] == "") {
            $error[] = "Tipe Kategori Wajib Diisi";
        }

        return $error;
    }
} 