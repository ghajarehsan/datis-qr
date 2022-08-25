<?php

namespace App\Http\Controllers;

use App\Exceptions\QrFormValidationException;
use App\Qr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QrController extends Controller
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return view('qrForm');
    }

    public function createQr()
    {
        try {
            $this->validateQr();

            $qr = $this->fillQrToDatabase();

            return response()->json([
                'data' => [
                    'qr' => $qr,
                ],
                'meta' => [
                    'message' => 'qr was created successfully',
                    'status' => 'successful'
                ]
            ], 200);

        } catch (\Exception $exception) {
            if ($exception->getCode() == 400) {
                $errors = unserialize($exception->getMessage());
            } else {
                $errors = 'ارور لطفا بعدا تلاش کنید';
            }
            return response()->json([
                'data' => null,
                'meta' => [
                    'message' => $errors,
                    'status' => 'validationError'
                ]
            ], 401);
        }
    }

    private function fillQrToDatabase()
    {
        return Qr::create([
            'serial_number' => $this->request->serial_number,
            'fullname' => $this->request->fullname,
            'mobile' => $this->request->mobile,
            'type' => $this->request->type,
        ]);
    }

    private function validateQr()
    {
        $validation = Validator::make($this->request->all(), [
            'serial_number' => 'required|integer|min:14',
            'fullname' => 'required|max:30',
            'mobile' => 'required|integer',
            'type' => 'required'
        ], [
            'serial_number.required' => 'سریال نامبر الزامی میباشد',
            'serial_number.integer' => 'سریال نامبر باید عدد باشد',
            'serial_number.min' => 'تعداد کاراکتر های شماره سریال بیش از حد مجاز است',
            'fullname.required' => 'نام و نام خانوادگی الزامی میباشد',
            'fullname.max' => 'تعداد کاراکتر های نام بیش از حد مجاز میباشد',
            'mobile.required' => 'شماره موبایل الزامی میباشد',
            'mobile.integer' => 'موبایل نا معتبر میباشد',
            'type.required' => 'نوع فروش الزامی میباشد'
        ]);

        if (count($validation->errors()) > 0) {
            $errors = serialize($validation->errors());
            throw new QrFormValidationException($errors, '400');
        }
    }

    // get all qr for admin
    public function getAllQr()
    {
        $qr = new Qr();

        $qr = $this->doFilterOnQr($qr);

        $qrCount = $qr->count();

        $perPage = 15;

        if ($this->request->has('perPage') && $this->request->perPage != null) {
            if ($this->request->perPage == 'all') {
                $perPage = $qrCount;
            } else {
                $perPage = $this->request->perPage;
            }
        }
        $qr = $qr->paginate($perPage);

        return response()->json([
            'data' => [
                'qrs' => $qr,
            ],
            'meta' => [
                'message' => null,
                'status' => 'successful'
            ]
        ], 200);
    }

    private function doFilterOnQr($qr)
    {
        if ($this->request->has('serial_number') && $this->request->serial_number != null) {
            $qr = $qr->where('serial_number', $this->request->serial_number);
        }
        if ($this->request->has('fullname') && $this->request->fullname != null) {
            $qr = $qr->where('fullname', 'like', '%' . $this->request->fullname . '%');
        }
        if ($this->request->has('mobile') && $this->request->mobile != null) {
            $qr = $qr->where('mobile', 'like', '%' . $this->request->mobile . '%');
        }
        if ($this->request->has('type') && $this->request->type != null) {
            $qr = $qr->where('type', $this->request->type);
        }
        if ($this->request->has('start_date') && $this->request->start_date != null) {
            $qr = $qr->whereDate('created_at', '>=', $this->request->start_date);
        }
        if ($this->request->has('end_date') && $this->request->end_date != null) {
            $qr = $qr->whereDate('created_at', '<=', $this->request->end_date);
        }
        return $qr;
    }

}
