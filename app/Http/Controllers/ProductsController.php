<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductsController extends Controller
{
    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $products = $this->repository->getAll($request->all());
            return view('products.index', compact('products'));

        } catch (Exception $e) {
            return $this->setJsonResponse('Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = $this->getValidationRules();
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->setJsonResponse('Error', $validator->errors()->first(), 412);
            }
            
            $response = $this->repository->save($request);

            if($response) {
                return $this->setJsonResponse('Success', 'Created', 200);
            }
        } catch (Exception $e) {
            return $this->setJsonResponse('Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->repository->getById($id);
        return view('products.create', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = $this->getValidationRules($id);
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->setJsonResponse('Error', $validator->errors()->first(), 412);
            }
            
            $response = $this->repository->save($request, $id);

            if($response) {
                return $this->setJsonResponse('Success', 'Updated', 200);
            }
        } catch (Exception $e) {
            return $this->setJsonResponse('Error', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $response = $this->repository->delete($id);
            return $this->setJsonResponse('Success', 'Deleted', 200);

        }catch(\Exception $e){
            return $this->setJsonResponse('Error', $e->getMessage(), 200);
        }
    }

    protected function getValidationRules($id = null)
    {
        $rules = [
            'name'          => 'required|unique:products,name,'.$id.',id,deleted_at,null',
            'price'         => 'required|numeric',
            'description'   => 'required',
        ];

        if($id) {
            $rules['images']   ='array';
            $rules['images.*'] = 'file|mimes:jpeg,png,jpg';

        } else {
            $rules['images']   ='required|array';
            $rules['images.*'] = 'required|file|mimes:jpeg,png,jpg';
        }

        return $rules;
    }

    protected function setJsonResponse($type, $msg, $code = 422)
    {
        return response()->json([
            'type'    => $type,
            'message' => $msg
        ], $code);
    }
}
