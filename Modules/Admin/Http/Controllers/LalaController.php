<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\Http\Requests\LalaRequest;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\CodeData;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;

class LalaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * @description: 
     * @param {LalaRequest} $lalaRequest
     * @param {string} $name 传入一个默认的参数
     * @return {*}
     */    
    public function test(LalaRequest $lalaRequest,int $id = 1){
        throw new ApiException(['status'=>StatusData::INTERNAL_SERVER_ERROR,
                                'message'=>MessageData::INTERNAL_SERVER_ERROR]);
        return $lalaRequest->input(key:"title");
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
