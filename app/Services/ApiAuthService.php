<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\User;
use App\Services\Auth\OtpService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class ApiAuthService
 *
 * This class provides authentication services including registration, password-based authentication,
 * and registration with OTP verification.
 */
class ApiAuthService
{
    /**
     * @var mixed $model The user model instance.
     */
    public $model;

    /**
     * @var mixed $modelRecord The user model record instance.
     */
    protected $modelRecord;

    /**
     * @var string $phoneNumberField The field name for the phone number in the user model.
     */
    protected $phoneNumberField = 'phone_number';

    /**
     * @var array $authenticateFields An array of field names used for authentication in the user model.
     */
    protected $authenticateFields = ['phone_number'];

    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing user registration data.
     * @return array An associative array with a token and message on successful registration.
     */
    public function register($request)
    {
        $record = $this->model::create($request->validated());
        $this->expireOtherTokens($this->model, $record->id);
        $token = $record->createToken(class_basename($this->model) . '-auth-token')->plainTextToken;
        return ['token' => $token, 'message' => 'Registration successful'];
    }
    /**
     * Expire all other tokens associated with the user.
     *
     * @return void
     */
    public function expireOtherTokens($model = null, $id = null)
    {

        PersonalAccessToken::where([['tokenable_type', $model ?? $this->model], ['tokenable_id', $id ?? $this->modelRecord->id]]) // Ensure the token is not already expired
            ->update(['expires_at' => now()]); // Expire the token
    }
    /**
     * Authenticate a user based on provided credentials.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing authentication data.
     * @return array|string An associative array with a token and message on successful authentication,
     *                     or a string indicating invalid credentials.
     */
    public function passwordAuth($request)
    {
        $record = $this->model::query();
        foreach ($this->authenticateFields as $field)
            $record->orWhere($field, ltrim($request->input($field), '0'))
                ->orWhere($field, $request->input($field))->orWhere($field, "0" . $request->input($field));
        $record = $record->first();

        if ($record && Hash::check($request->input('password'), $record->password)) {
            $token = $record->createToken(class_basename($this->model) . '-auth-token')->plainTextToken;
            return [
                'token' => $token,
                'message' => 'Authentication successful. Token generated.',
            ];
        }

        return 'Invalid credentials. Authentication failed.';
    }


    /**
     * Register a new user with OTP verification.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing user registration data.
     * @return array An associative array with a token and message on successful registration with OTP verification.
     */
    public function registerWithOtpVerification($request)
    {
        try {
            DB::beginTransaction();

            $otpService = new OtpService();
            $otpService->generateOtp();

            $record = $this->model::create(array_merge([
                'otp' => $otpService->otp,
                'current_credit_amount' => getSetting('USER_INIT_BALANCE', 0)
            ], $request->validated()));

            // Send OTP SMS
            $otpResult = $otpService->setModelRecord($record)->sendOtpSms();

            if ($otpResult['status']) {
                DB::commit();
                return ['message' => 'Registration successful. OTP Sent to ' . $request->phone_number];
            } else {
                DB::rollBack();
                return $otpResult['message'];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Error during registration. Please try again.';
        }
    }

    /**
     * Authenticate a user using OTP-based verification.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing user identification data.
     * @return array An associative array indicating the result of the OTP authentication.
     */
    public function otpAuth($request)
    {
        $record = $this->model::query();
        foreach ($this->authenticateFields as $field)
            $record->orWhere($field, ltrim($request->input($field), '0'))
                ->orWhere($field, $request->input($field))->orWhere($field, "0" . $request->input($field));
        $record = $record->first();
        if ($record) {
            if($record->is_blocked)
                return ['status' => false, 'message' => 'المستخدم محظور من إستخدام التطبيق'];
            // Send OTP to the user's phone number
            $otpService = new OtpService();
            $otpResult = $otpService->generateOtp()->setModelRecord($record)->sendOtpSms();
            if ($otpResult['status'])
                return ['status' => true, 'message' => 'تم إرسال رسالة بها رقم OTP الى رقم الهاتف المدخل'];
            return ['status' => false, 'message' => $otpResult['message']];
        }
        return ['status' => false, 'message' => 'رقم الهاتف غير مسجل'];
    }

    /**
     * Create a token for the authenticated user record.
     *
     * @param mixed $record The user model record instance.
     * @return string The plain text authentication token.
     */
    public function createToken($record)
    {
        return $record->createToken(class_basename($this->model) . 'auth-token')->plainTextToken;
    }
    /**
     * Set the user model for authentication.
     *
     * @param mixed $model The user model instance.
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Set the user model record for authentication.
     *
     * @param mixed $record The user model record instance.
     * @return $this
     */
    public function setModelRecord($record)
    {
        $this->modelRecord = $record;
        return $this;
    }

    /**
     * Set the field name for the phone number in the user model.
     *
     * @param string $phoneField The field name for the phone number.
     * @return $this
     */
    public function setPhoneNumberField($phoneField)
    {
        $this->phoneNumberField = $phoneField;
        return $this;
    }

    /**
     * Set the fields used for authentication in the user model.
     *
     * @param array $authenticateFields An array of field names used for authentication.
     * @return $this
     */
    public function setAuthenticateFields(array $authenticateFields)
    {
        $this->authenticateFields = $authenticateFields;
        return $this;
    }
}
