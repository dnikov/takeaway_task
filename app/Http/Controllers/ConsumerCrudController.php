<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response,
    App\Consumer,
    App\Http\Requests\Consumer as ConsumerRequest;

class ConsumerCrudController extends Controller
{
    /**
     * List all consumers
     * @return Consumer[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Consumer::all();
    }

    /**
     * Get single consumer by ID
     * @param $id
     * @return  Consumer[]
     */
    public function show($id)
    {
        return Consumer::find($id);
    }

    /**
     * Store the incoming consumer.
     *
     * @param  ConsumerRequest $request
     * @return Response|Consumer
     */
    public function store(ConsumerRequest $request)
    {

        return Consumer::create($request->all());
    }

    /**
     * Update consumer if exist
     *
     * @param ConsumerRequest $request
     * @param $id
     * @return Response|Consumer
     */
    public function update(ConsumerRequest $request, $id)
    {
        $consumer = Consumer::findOrFail($id);
        $consumer->update($request->all());

        return $consumer;
    }

    /**
     * Delete consumer if exist
     *
     * @param ConsumerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(ConsumerRequest $request, $id)
    {
        $consumer = Consumer::findOrFail($id);
        $consumer->delete();

        return response()->json(null, 204);
    }
}
