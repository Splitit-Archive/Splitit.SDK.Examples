<?php

require_once(__DIR__ . '/vendor/autoload.php');

use SplititSdkClient\ApiException;
use SplititSdkClient\Configuration;
use SplititSdkClient\Model\PaymentWizardData;
use SplititSdkClient\Model\RedirectUrls;
use SplititSdkClient\Model\VerifyPaymentRequest;
use SplititSdkClient\Api\LoginApi;
use SplititSdkClient\Api\InstallmentPlanApi;
use SplititSdkClient\Model\LoginRequest;
use SplititSdkClient\Model\PlanData;
use SplititSdkClient\Model\ConsumerData;
use SplititSdkClient\Model\AddressData;
use SplititSdkClient\Model\MoneyWithCurrencyCode;
use SplititSdkClient\Model\InitiateInstallmentPlanRequest;


class PaymentForm_3D
{
    /**
     * @var InstallmentPlanApi
     */
    protected $installmentPlanApi;

    const MERCHANT_AMOUNT = 600;

    public function __construct()
    {
        // TODO: place api key here
        // Configuration::sandbox()->setApiKey('_YOUR_SANDBOX_API_KEY_');
        Configuration::sandbox()->setApiKey('0d756f86-29c3-4fde-9fa3-f21c898dfe0f');
    }

    /**
     * Authenticate
     *
     * @param $username string username
     * @param $password string password
     * @throws ApiException
     */
    public function Login($username, $password)
    {
        $loginApi = new LoginApi(Configuration::sandbox());
        $request = new LoginRequest();

        $request->setUserName($username);
        $request->setPassword($password);

        $loginResponse = $loginApi->loginPost($request);

        $sessionId = $loginResponse->getSessionId();

        $this->installmentPlanApi = new InstallmentPlanApi(
            Configuration::sandbox(),
            $sessionId
        );
    }

    /**
     * Initiates the plan
     *
     * @throws ApiException
     */
    public function Initiate()
    {
        // TODO: after the shopper authorized and completed the payment you need to redirect him to our page
        $planData = new PlanData(array(
            'number_of_installments' => 3,
            'amount' => new MoneyWithCurrencyCode(array("value" => 600, "currency_code" => "USD")),
            'ref_order_number' => 'abc123',
            'auto_capture' => true,
            'attempt3_d_secure' => true,
        ));

        $paymentWizardData = new PaymentWizardData(array("requested_number_of_installments" => "2,3,4,5,6"));

        // After user successfully interacts with the splitit.com they would be redirected to provided Succeeded URL with
        // InstallmentPlanNumber as a parameter in GET request. It is required to continue the flow.
        $redirectUrls = new RedirectUrls(array(
            "canceled" => "http://localhost/examples/Canceled",
            "failed" => "http://localhost/examples/Failed",
            "succeeded" => "http://localhost/examples/Succeeded",
        ));

        // TODO: (optional) set data to pre-fill the address data in form
        $billingAddress = new AddressData(array(
            "address_line" => "260 Madison Avenue.",
            "city" => "New York",
            "state" => "NY",
            "country" => "USA",
            "zip" => "10016",
        ));

        // TODO: (optional) set data to pre-fill the customer data in form
        $consumerData = new ConsumerData(array(
            "full_name" => "John Smith",
            "email" => "j.smith@fake-email.com",
            "phone_number" => "4343-555-45",
            "culture_name" => "en-us"
        ));

        // Init installment plan request
        $initiateRequest = new InitiateInstallmentPlanRequest();
        $initiateRequest->setPlanData($planData);
        $initiateRequest->setPaymentWizardData($paymentWizardData);
        $initiateRequest->setRedirectUrls($redirectUrls);
        $initiateRequest->setBillingAddress($billingAddress);
        $initiateRequest->setConsumerData($consumerData);

        // initResponse contains urls to which you should redirect your customers (eg. checkoutUrl, termsConditionsUrl, privacyPolicyUrl, learnMoreUrl)
        $initResponse = $this->installmentPlanApi->installmentPlanInitiate($initiateRequest);

        // Use the T&C, PrivacyPolicy and the LearnMore urls
        // Save the Installment plan number for future use during the creation of a new plan

        if ($initResponse->getResponseHeader()->getSucceeded()) {
            // TODO: take the $initResponse->getCheckoutUrl() and redirect your shopper to it
        } else {
            // TODO: show the return error from $initResponse->getResponseHeader()->getErrors()
        }
    }

    /**
     * Checks for potential fraud attempts
     * This function MUST be called after payment is processed on Splitit's end, before merchant closes the order on his end
     *
     * @param $installmentPlanNumber
     * @throws ApiException
     */
    public function VerifyPayment($installmentPlanNumber)
    {
        $verifyPaymentRequest = new VerifyPaymentRequest(array('installment_plan_number' => $installmentPlanNumber));

        $verifyResponse = $this->installmentPlanApi->installmentPlanVerifyPayment($verifyPaymentRequest);

        // Verifies amount
        // TODO: please fill the value {MERCHANT_AMOUNT} from your session
        $paymentSuccessful = $verifyResponse->getResponseHeader()->getSucceeded();
        $paymentVerified = $verifyResponse->getIsPaid() && $verifyResponse->getOriginalAmountPaid() == self::MERCHANT_AMOUNT;

        if ($paymentSuccessful && $paymentVerified) {
            // TODO: Success - close order in your system
        } else {
            // TODO: call the InstallmentPlanCancel function with the installment plan number
        }
    }
}