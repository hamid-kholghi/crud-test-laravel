<?php

namespace Domains\Customer\Services;

use Domains\Customer\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use App\Utility\ApiResponse;
use Exception;

class CustomerService
{
    public function index()
    {
        return Customer::select('id', 'first_name', 'last_name', 'date_of_birth', 'phone_number', 'email', 'bank_account_number')
            ->paginate();
    }

    public function show($id)
    {
        try {
            return Customer::where('id', '=', $id)->firstOrFail();

        } catch (Exception $exception) {
            Log::debug('CustomerService@show', [
                'message' => $exception->getMessage(),
                'errorCode' => $exception->getCode(),
                'data' => 'customer_id:' . $id,
            ]);

            return ApiResponse::failed(Response::HTTP_INTERNAL_SERVER_ERROR, 'customer not found');
        }
    }

    public function store($request)
    {
        try {
            $customer = new Customer();
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->date_of_birth = $request->input('date_of_birth');
            $customer->phone_number = $request->input('phone_number');
            $customer->email = $request->input('email');
            $customer->bank_account_number = $request->input('bank_account_number');
            $customer->save();

            return $customer;
        } catch (Exception $exception) {
            Log::debug('CustomerService@store', [
                'message' => $exception->getMessage(),
                'errorCode' => $exception->getCode(),
                'data' => $request,
            ]);

            return ApiResponse::failed(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal server error');
        }
    }

    public function update($request, $id)
    {
        try {
            $customer = Customer::where('id', '=', $id)->firstOrFail();
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->date_of_birth = $request->input('date_of_birth');
            $customer->phone_number = $request->input('phone_number');
            $customer->email = $request->input('email');
            $customer->bank_account_number = $request->input('bank_account_number');
            $customer->save();

            return $customer;
        } catch (Exception $exception) {
            Log::debug('CustomerService@update', [
                'message' => $exception->getMessage(),
                'errorCode' => $exception->getCode(),
                'data' => $request,
            ]);

            return ApiResponse::failed(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal server error');
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::where('id', '=', $id)->firstOrFail();
            $customer->delete();

            return $customer;
        } catch (Exception $exception) {
            Log::debug('CustomerService@destroy', [
                'message' => $exception->getMessage(),
                'errorCode' => $exception->getCode(),
                'data' => 'customer_id:' . $id,
            ]);

            return ApiResponse::failed(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal server error');
        }
    }
}
