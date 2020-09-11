<?php

require_once(__DIR__ . '/vendor/autoload.php');

use SplititSdkClient\ApiException;
use SplititSdkClient\Configuration;
use SplititSdkClient\Model\CreateInstallmentPlanRequest;
use SplititSdkClient\Model\GetInstallmentsPlanSearchCriteriaRequest;
use SplititSdkClient\Model\InstallmentPlanQueryCriteria;
use SplititSdkClient\Model\PaymentToken;
use SplititSdkClient\Model\PaymentWizardData;
use SplititSdkClient\Model\PlanApprovalEvidence;
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


class PayWithCCToken
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
        $planData = new PlanData(array(
            'number_of_installments' => 3,
            'amount' => new MoneyWithCurrencyCode(array("value" => 600, "currency_code" => "USD")),
            'ref_order_number' => 'abc123',
            'auto_capture' => true,
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
        $initiateRequest->setBillingAddress($billingAddress);
        $initiateRequest->setConsumerData($consumerData);

        // initResponse contains urls to which you should redirect your customers (eg. checkoutUrl, termsConditionsUrl, privacyPolicyUrl, learnMoreUrl)
        $initResponse = $this->installmentPlanApi->installmentPlanInitiate($initiateRequest);

        return (int)$initResponse->getInstallmentPlan()->getInstallmentPlanNumber();
    }

    /**
     * Retrieves the credit card token from previous splitit installment plan of a returning shopper
     *
     * @param $oldInstallmentPlanNumber
     * @return string
     * @throws ApiException
     */
    public function GetCCToken($oldInstallmentPlanNumber)
    {
        $getInstallmentsPlanSearchCriteriaRequest = new GetInstallmentsPlanSearchCriteriaRequest(array(
            'query_criteria' => new InstallmentPlanQueryCriteria(array(
                    'installment_plan_number' => $oldInstallmentPlanNumber
                )
            )
        ));
        $response = $this->installmentPlanApi->installmentPlanGet($getInstallmentsPlanSearchCriteriaRequest);

        return $response->getPlansList()[0]->getActiveCard()->getToken();
    }

    /**
     * Make a payment for the new plan with an existing card token
     *
     * @param $newPlanNumber
     * @param $token
     * @throws ApiException
     */
    public function PayWithCCToken($newPlanNumber, $token)
    {
        // TODO: Use as a handler for the subsequent Checkout requests
        $createInstallmentPlanRequest = new CreateInstallmentPlanRequest(array(
            'installment_plan_number' => $newPlanNumber,
            'plan_approval_evidence' => new PlanApprovalEvidence(array('are_terms_and_conditions_approved' => true)),
            'payment_token' => new PaymentToken(array(
                'token' => $token,
                'type' => 'card',
            )),
        ));
        $this->installmentPlanApi->installmentPlanCreate($createInstallmentPlanRequest);
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