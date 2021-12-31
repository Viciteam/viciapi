<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\TrackingDetail;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        #save challenge first and get challenge id

        
        $tracking = Tracking::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'action_id' => $data['action_id'],
            'meta' => 'no value for now'

        ]);
        
        $tracking_id = $tracking['id'];
        $tdetails = [];
        foreach($data['details'] as $detail){
            $trackingdetail = TrackingDetail::create([
                'tracking_id' => $tracking_id,
                'field' => $detail['field'],
                'data' => $detail['data']
    
            ]);
            array_push($tdetails,$trackingdetail);
        }

        $response = [
            'tracking' => $tracking,
            'tracking details' => $tdetails
        ];
        $code = 201;

        return response($response, $code);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
