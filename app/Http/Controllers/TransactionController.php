<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'List Data Transaction',
            'data' => $data,
            'code' => 200
        ];

        return response()->json($response);
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
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:expense,revenue'],
        ]);

        if($validator->fails()){
            $response = [
                'message' => 'Input Data Invalid',
                'data' => $validator->errors(),
                'code' => 400
            ];
            return response()->json($response);
        }

        try{
            $data = Transaction::create($request->all());
            $response = [
                'message' => 'Created Data Transaction',
                'data' => $data,
                'code' => 200
            ];

            return response()->json($response);
        }catch(Exception $e){
            $response = [
                'message' => 'Failed: ' . $e->getMessage(),
                'data' => NULL,
                'code' => 500
            ];
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $response = [
            'message' => 'Show Data Transaction',
            'data' => $transaction,
            'code' => 200
        ];

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', 'in:expense,revenue'],
        ]);

        if($validator->fails()){
            $response = [
                'message' => 'Input Data Invalid',
                'data' => $validator->errors(),
                'code' => 400
            ];
            return response()->json($response);
        }

        try{
            $transaction->update($request->all());
            $response = [
                'message' => 'Updated Data Transaction',
                'data' => $transaction,
                'code' => 200
            ];

            return response()->json($response);
        }catch(Exception $e){
            $response = [
                'message' => 'Failed: ' . $e->getMessage(),
                'data' => NULL,
                'code' => 500
            ];
            return response()->json($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction = Transaction::findOrFail($transaction->id);
        try{
            $transaction->delete();
            $response = [
                'message' => 'Deleted Data Transaction',
                'data' => $transaction,
                'code' => 200
            ];

            return response()->json($response);
        }catch(Exception $e){
            $response = [
                'message' => 'Failed: ' . $e->getMessage(),
                'data' => NULL,
                'code' => 500
            ];
            return response()->json($response);
        }
    }
}
