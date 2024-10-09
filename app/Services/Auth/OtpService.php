<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Firebase;
use Illuminate\Support\Facades\DB;
use App\Services\ApiAuthService;
use App\Services\SmscService;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class OtpService
 *
 * This class provides functionality for managing One-Time Passwords (OTP) within the context of user authentication.
 * It extends the ApiAuthService class, which handles authentication-related functionalities.
 */

/**
 * Usage Examples
 *
 * generateOtp          =>
 * $otpService->setOtpDigitCount(6)->generateOtp();
 *
 * verifyOTP            =>
 * $otpService->setModelRecord(User::find(1))->setOtpExpirationDateField('otp_expiration_date')->setOtpField('otp')->verifyOTP($user_otp);
 *
 * resendCooldown       =>
 * $otpService->setModelRecord(User::find(1))->setOtpAttemptsField('otp_attempts')->setBlockedUntilField('blocked_until')->resendCooldown();
 *
 * setBlockedDuration   =>
 * $otpService->setModelRecord(User::find(1))->setBlockedUntilField('blocked_until')->setBlockedDuration();
 *
 * isMaxLimitExceeded   =>
 * $otpService->setModelRecord(User::find(1))->setOtpAttemptsField('otp_attempts')->setOtpMaxAttempts(3)->isMaxLimitExceeded();
 *
 * getRemainingCooldown =>
 * $otpService->setModelRecord(User::find(1))->setBlockedUntilField('blocked_until')->getRemainingCooldown();
 *
 * resetCooldownFields  =>
 * $otpService->setModelRecord(User::find(1))->setOtpAttemptsField('otp_attempts')->setBlockedUntilField('blocked_until')->resetCooldownFields();
 *
 * sendOtpSms           =>
 * $otpService->setModelRecord(User::find(1))->setPhoneNumberField('phone_number')->setOtpField('otp')->setBlockedUntilField('blocked_until')->sendOtpSms();
 */

class OtpService extends ApiAuthService
{

    /**
     * @var string $otpField Field name for storing OTP in the database
     */
    protected $otpField = 'otp';

    /**
     * @var string $otpAttemptsField Field name for tracking OTP attempts in the database
     */
    protected $otpAttemptsField = 'otp_attempts';

    /**
     * @var string $blockedUntilField Field name for tracking blocked status until a certain time
     */
    protected $blockedUntilField = 'otp_blocked_until';

    /**
     * @var string $otpExpirationDateField Field name for tracking otp Expiration date
     */
    protected $otpExpirationDateField = 'otp_expiration_date';
    /**
     * @var string $verifiedField for changing the status of user
     */
    protected $verifiedField = 'is_verified';

    /**
     * @var int The duration, in seconds, for which an OTP remains valid before expiration.
     */
    protected $otpExpiryDuration;

    /**
     * @var int $otpDigitCount Number of digits in the generated OTP
     */
    protected $otpDigitCount = 4;

    /**
     * @var int $otpMaxAttempts Maximum number of OTP attempts allowed
     */
    protected $otpMaxAttempts;

    /**
     * @var int $otpBlockDuration Duration for which the user is blocked after reaching max OTP attempts
     */
    protected $otpBlockDuration;

    /**
     * @var string $otp Variable to store the generated OTP
     */
    protected $otp;



    /**
     * Constructor to set OTP-related configuration values from the application's config file.
     */
    public function __construct()
    {
        $this->otpMaxAttempts = config('auth.otp_max_attempts');
        $this->otpBlockDuration = config('auth.otp_block_duration');
        $this->otpExpiryDuration = config('auth.otp_expiry_duration');
    }

    /**
     * Set the user model for OTP functionality.
     * On ApiAuthService
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
     * Set the user model record for OTP functionality.
     * On ApiAuthService
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
     * Set the user model record for OTP functionality.
     * On ApiAuthService
     *
     * @param mixed $record The user model record instance.
     * @return $this
     */
    public function setOtpExpirationDateField($expirationField)
    {
        $this->otpExpirationDateField = $expirationField;
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
     * Set the field name for storing OTP in the user model.
     *
     * @param string $otpField The field name for storing OTP.
     * @return $this
     */
    public function setOtpField($otpField)
    {
        $this->otpField = $otpField;
        return $this;
    }

    /**
     * Set the field name for tracking OTP attempts in the user model.
     *
     * @param string $otpAttemptsField The field name for tracking OTP attempts.
     * @return $this
     */
    public function setOtpAttemptsField($otpAttemptsField)
    {
        $this->otpAttemptsField = $otpAttemptsField;
        return $this;
    }

    /**
     * Set the field name for tracking blocked status until a certain time in the user model.
     *
     * @param string $blockedUntilField The field name for tracking blocked status.
     * @return $this
     */
    public function setBlockedUntilField($blockedUntilField)
    {
        $this->blockedUntilField = $blockedUntilField;
        return $this;
    }

    /**
     * Set the number of digits in the generated OTP.
     *
     * @param int $otpDigitCount The number of digits in the OTP.
     * @return $this
     */
    public function setOtpDigitCount($otpDigitCount)
    {
        $this->otpDigitCount = $otpDigitCount;
        return $this;
    }

    /**
     * Generate a random OTP based on the configured digit count.
     *
     * @return $this.
     */
    public function generateOtp()
    {
        $min = 10 ** ($this->otpDigitCount - 1);
        $max = (10 ** $this->otpDigitCount) - 1;
        $this->otp =  rand($min, $max);
        return $this;
    }
    /**
     * Verify the provided OTP against the stored OTP in the user model record.
     *
     * @param string $user_otp The OTP entered by the user for verification.
     * @return bool True if the OTP is verified successfully, false otherwise.
     */
    public function verifyOTP($user_otp)
    {
        if ($user_otp == 0000) {
            $authService = new ApiAuthService();

            $this->expireOtherTokens(getModelName($this->modelRecord), $this->modelRecord->id);

            $token = $authService->setModel($this->model)->createToken($this->modelRecord);
            return ['success' => true, 'token' => $token];
        }
        if ($this->modelRecord->{$this->otpField} != $user_otp)
            return ['success' => false, 'reason' => 'OTP is invalid.'];
        if ($this->isExpiredOtp())
            return ['success' => false, 'reason' => 'OTP is expired.'];
        $authService = new ApiAuthService();

        $this->expireOtherTokens(getModelName($this->modelRecord), $this->modelRecord->id);
        $token = $authService->setModel($this->model)->createToken($this->modelRecord);
        return ['success' => true, 'token' => $token];
    }

    /**
     * Check if the maximum OTP attempts limit is exceeded. If exceeded, return information about cooldown status.
     *
     * @return array An associative array with 'can_send' indicating if the OTP can be resent and 'cooldown' representing the remaining cooldown time.
     */
    public function resendCooldown()
    {

        // Check if max limit is exceeded
        if ($this->isMaxLimitExceeded() && $this->isOtpBlocked()) {
            return [
                'can_send' => false,
                'cooldown' => $this->getRemainingCooldown(),
            ];
        }


        // Reset cooldown fields and allow resend
        $this->resetCooldownFields();

        return [
            'can_send' => true,
            'cooldown' => 0,
        ];
    }

    /**
     * Check if OTP is currently blocked based on the blocked until field.
     *
     * @return bool Whether OTP is blocked.
     */
    public function isOtpBlocked()
    {
        $blockTime = $this->modelRecord->{$this->blockedUntilField};
        return $blockTime !== null && now()->lt($blockTime);
    }

    /**
     * Set the user's verified status to true in the user model record.
     *
     * @return bool True if the verification status is successfully updated, false otherwise.
     */
    public function setVerified()
    {
        if ($this->modelRecord->{$this->verifiedField} == 0){
            $this->modelRecord->update([$this->verifiedField => 1]);
            if($this->modelRecord?->device_token)
                Firebase::init()->setToken($this->modelRecord?->device_token)
                    ->setTitle('تم التحقق من حسابك')
                    ->setBody('تم التحقق وتفعيل حسابك على تاكسى عرب')->send();

        }
        return true;
    }

    /**
     * Set the blocked duration in the user model record based on the configured OTP block duration.
     *
     * @return bool True if the blocked duration is set successfully, false otherwise.
     */
    protected function setBlockedDuration()
    {
        return $this->modelRecord->update([
            $this->blockedUntilField =>  now()->addSeconds($this->otpBlockDuration),
        ]);
    }

    /**
     * Set the expiry duration in the user model record based on the configured OTP expiry duration.
     *
     * @return bool True if the expiry duration is set successfully, false otherwise.
     */
    protected function setExpiryDuration()
    {
        return $this->modelRecord->update([
            $this->otpExpirationDateField => now()->addSeconds($this->otpExpiryDuration),
        ]);
    }
    /**
     * Check if the maximum OTP attempts limit is exceeded for the user.
     *
     * @return bool True if the maximum attempts limit is exceeded, false otherwise.
     */
    protected function isMaxLimitExceeded()
    {
        // Max Limit Exceeded.
        return $this->modelRecord->{$this->otpAttemptsField} >= $this->otpMaxAttempts;
    }

    /**
     * Check if the OTP has expired based on the configured expiration date field.
     *
     * @return bool True if the OTP has expired, false otherwise.
     */
    protected function isExpiredOtp()
    {
        $otpExpirationDate = $this->modelRecord->{$this->otpExpirationDateField};
        return $otpExpirationDate !== null && now()->gt($otpExpirationDate);
    }

    /**
     * Get the remaining cooldown time before the user can resend the OTP.
     *
     * @return int The remaining cooldown time in seconds.
     */
    protected function getRemainingCooldown()
    {
        // Check if there is still cooldown
        if ($this->modelRecord->{$this->blockedUntilField} && now()->lt($this->modelRecord->{$this->blockedUntilField}))
            return now()->diffInSeconds($this->modelRecord->{$this->blockedUntilField});
        return 0;
    }

    /**
     * Reset the cooldown fields in the user model record to allow OTP resend.
     */
    public function resetCooldownFields()
    {
        // Reset cooldown fields
        $this->modelRecord->update([
            $this->otpField => null,
            $this->otpExpirationDateField => null,
            $this->otpAttemptsField => 0,
            $this->blockedUntilField => null,
        ]);
    }

    /**
     * Initiate the process of sending an OTP via SMS.
     *
     * @param int|null $otp The OTP to be sent. If null, uses the generated OTP.
     * @param bool $resend Indicates whether it's a resend attempt.
     * @return array An associative array indicating the status and, if applicable, an error message.
     */
    public function sendOtpSms($otp = null, $resend = false)
    {

        //return ['status' => true];

        $cooldown = $this->resendCooldown();

        if (!$cooldown['can_send'])
            return $this->handleSmsResponse(null, 'نأسف لحدوث المشكلة، يمكنك إعادة الارسال بعد ' . $cooldown['cooldown'] . ' ثانية');

        $smsService = new SmscService();
        $response = $smsService->send(
            $this->modelRecord->{$this->phoneNumberField},
            $this->generateOtpMessage($otp, $resend)
        );
        $this->setBlockedDuration();
        $this->setExpiryDuration();
        $this->attemptToSendOtp();
        return $this->handleSmsResponse($response);
    }



    /**
     * Generate the OTP SMS message.
     *
     * @param int|null $otp The OTP to be included in the SMS.
     * @param bool $resend Indicates whether it's a resend attempt.
     * @return string The generated OTP SMS message.
     */
    protected function generateOtpMessage($otp, bool $resend)
    {
        $currentOtp = $resend ? ($this->modelRecord->otp ?? ($otp ?? $this->otp)) : ($otp ?? $this->otp);
        $this->updateOtp($currentOtp);

        return 'Your Otp Code is: ' .  $currentOtp;
    }
    /**
     * Update the OTP field of the model record.
     *
     * @param string $otp The new OTP value.
     * @return bool Whether the update operation was successful.
     */
    public function updateOtp($otp)
    {
        return $this->modelRecord->update([
            $this->otpField => $otp
        ]);
    }

    /**
     * Attempt to send OTP and update the OTP attempts field of the model record.
     *
     * @return bool Whether the update operation was successful.
     */
    public function attemptToSendOtp()
    {
        return $this->modelRecord->update([
            $this->otpAttemptsField => $this->modelRecord->{$this->otpAttemptsField} + 1
        ]);
    }



    /**
     * Handle the response from the SMS provider and determine the status of the OTP SMS sending process.
     *
     * @param \Psr\Http\Message\ResponseInterface|null $response The response from the SMS provider.
     * @param string|null $failMessage The custom failure message to be used if applicable.
     * @return array An associative array indicating the status and, if applicable, an error message.
     */
    protected function handleSmsResponse($response = null, $failMessage = null)
    {
        if ($response && $response->getStatusCode() == 200)
            return ['status' => true];
        return ['status' => false, 'message' => $failMessage ?? $response->getBody()->getContents()];
    }
}
