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
        $listCategory = $this->categoryModel->listCategory();
        $data['categories'] = $listCategory;
        return view('list/category_list', $data);
    }

    public function add()
    {
        return view('forms/category_add');
    }

    public function insert()
    {
        $data = array(
            'category_name' => $this->request->getPost('category_name'),
            'category_type' => $this->request->getPost('category_type'),
            'category_description' => $this->request->getPost('category_description'),
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
                return redirect()->to(base_url('categories'));
            }
        }
    }

    public function edit()
    {
        $id = $this->request->getGet('id');
        $category = $this->categoryModel->getCategory($id);
        $data['category'] = $category;
        session()->setFlashdata('inputs', $category);
        return view('forms/category_edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('category_id');
        $data = array(
            'category_name' => $this->request->getPost('category_name'),
            'category_type' => $this->request->getPost('category_type'),
            'category_description' => $this->request->getPost('category_description'),
            'updatedby' => 1
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
                return redirect()->to(base_url('categories'));
            }
        }
    }

    public function delete()
    {
        $id = $this->request->getGet('id');

        $delete = $this->categoryModel->deleteCategory($id);
        if ($delete) {
            session()->setFlashdata('success', 'Delete Kategori Berhasil');
            return redirect()->to(base_url('categories'));
        } else {
            session()->setFlashdata('warning', 'Delete Kategori Gagal');
            return redirect()->to(base_url('categories'));
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