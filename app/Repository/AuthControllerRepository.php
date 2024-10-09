<?php

namespace App\Repository;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegisterPhoneNameRequest;
use App\Http\Requests\Users\UserRegisterRequest;
use App\Models\Driver;
use App\Models\User;
use App\Services\ApiAuthService;
use App\Services\Auth\OtpService;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthControllerRepository extends Controller
{
    protected $authModel;

    /**
     * Authenticate a user based on provided password credentials.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing authentication data.
     * @return \Illuminate\Http\JsonResponse A JSON response with the authentication result.
     */
    public function passwordAuthenticate(Request $request)
    {
        $auth = new ApiAuthService();
        $auth = $auth->setModel($this->authModel)->passwordAuth($request);
        return handleApiResponse($auth);
    }

    /**
     * Authenticate a user using OTP-based verification.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing user identification data.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the result of the OTP authentication.
     */
    public function otpAuthenticate(Request $request)
    {
        $auth = new ApiAuthService();
        $auth = $auth->setModel($this->authModel)->otpAuth($request);
        if ($auth['status']) return successMessageResponse($auth['message']);
        return failMessageResponse($auth['message']);
    }

    /**
     * Check phone name for user registration.
     *
     * @param \App\Http\Requests\UserRegisterRequest $request The HTTP request containing user registration data.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful receipt of user registration information.
     */
    public function checkPhoneName(UserRegisterPhoneNameRequest $request)
    {
        return successMessageResponse(
            'تم تسجيل رقم الهاتف برجاء استكمال الخطوة التالية'
        );
    }

    /**
     * Register a new user with OTP verification.
     *
     * @param \App\Http\Requests\UserRegisterRequest $request The HTTP request containing user registration data.
     * @return \Illuminate\Http\JsonResponse A JSON response with the registration result.
     */
    public function register(UserRegisterRequest $request)
    {
        $authService = new ApiAuthService();
        $register = $authService->setModel($this->authModel)->registerWithOtpVerification($request);
        return handleApiResponse($register);
    }


    /**
     * Verify the user's OTP using the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing OTP for verification.
     * @return array An associative array with a success or failure message for user feedback.
     */
    public function verifyUserOtpRegister(Request $request)
    {
        $user = $this->authModel::where('phone_number', ltrim($request->phone_number, '0'))->firstOrFail();
        return $this->verifyUserOtp($user, $request);
    }


    /**
     * Verify the user's OTP using the provided request data.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing OTP for verification.
     * @return array An associative array with a success or failure message for user feedback.
     */
    public function verifyUserOtpAuth(Request $request)
    {
        $user = $this->authModel::whereIn('phone_number', [
            ltrim($request->phone_number, '0'),
            $request->phone_number,
            "0" . $request->phone_number,
        ])->firstOrFail();
        return $this->verifyUserOtp($user, $request);
    }

    public function verifyUserOtp($user, $request)
    {
        $otpService = new OtpService();

        // Use the OtpService to handle OTP verification
        $verificationResult = $otpService
            ->setModelRecord($user)
            ->verifyOTP($request->otp);

        if ($verificationResult['success']) {
            // OTP is verified successfully
            $otpService->setVerified();
            $otpService->resetCooldownFields();

            return successResponse(
                [
                    'token' => $verificationResult['token']
                ],
                class_basename($this->authModel) . ' verification successful. Thank you for confirming your identity.'
            );
        }

        // warning -> the next block is for developing phase only

        $otpService->setVerified();
        $otpService->resetCooldownFields();
        return successResponse(
            [
                'token' => $verificationResult['token'],
            ],
            class_basename($this->authModel) . ' verification successful. Thank you for confirming your identity.'
        );

        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////

        // Handle OTP verification failure
        return failMessageResponse($verificationResult['reason']);
    }
    /**
     * Send an OTP via SMS to the user's provided phone number.
     *
     * @param string $phone_number The phone number to which the OTP SMS will be sent.
     * @return array An associative array with a success or failure message for user feedback.
     */
    public function sendOtpSms($phone_number)
    {
        $otpService = new OtpService();
        $user = $this->authModel->where('phone_number', $phone_number)->firstOrFail();

        // Use the OtpService to generate and send OTP via SMS
        $sendingResult = $otpService
            ->setModelRecord($user)
            ->generateOtp()
            ->setPhoneNumberField('phone_number')
            ->sendOtpSms();

        if ($sendingResult['status'])
            return successMessageResponse('An OTP has been sent to your phone number. Please check and enter it for verification.');
        // Handle OTP sending failure
        return failMessageResponse($sendingResult['message']);
    }
}
