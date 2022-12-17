<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
	protected $model;

	public function __construct(Product $model)
	{
		$this->model = $model;
	}

	public function getAll($param)
	{
		return $this->model->paginate(15);
	}

	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}

	public function save($request, $id = null)
	{
		$model = $this->model;
		if($id) $model = $this->model->findOrFail($id);
		$model->name = $request->input('name', null);
		$model->price = $request->input('price', null);
		$model->description = $request->input('description', null);
		$model->save();

		if(!empty($request->images)){
			foreach($request->images as $key => $value) {
				$file= $value;
				$filename= date('YmdHi').'-'.$key.$file->getClientOriginalName();
				$file->move(storage_path('app/public/products/images'), $filename);
			
				$model->images()->insert([
					'product_id' => $model->id,
					'filename' => $filename
				]);
			}
		}

		return true;
	}

	public function delete($id)
	{
		return $this->model->findOrFail($id)->delete();
	}
}