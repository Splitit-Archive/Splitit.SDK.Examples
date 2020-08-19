using System;
using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Client;
using Splitit.SDK.Client.Model;

namespace Splitit.SDK.Example
{
    /// <summary>
    /// Scenario where the charging is not immediate and instead is set in the future
    /// </summary>
    class PaymentFormDepositFutureChargeDate
    {
        InstallmentPlanApi PlanApi { get; set; }
        const int MERCHANT_AMOUNT = 600;

        // Authenticate with the api
        void Login(string username, string password)
        {
            var loginApi = new LoginApi(Configuration.Sandbox);
            var request = new LoginRequest(userName: username, password: password);

            var loginResult = loginApi.LoginPost(request);

            PlanApi = new InstallmentPlanApi(Configuration.Sandbox, sessionId: loginResult.SessionId);
        }

        // Initiates the plan
        // TODO: Use as a handler for Checkout request
        void InitiateInstallmentPlan()
        {
            // TODO: set this value to when you want the charging to begin
            var firstChargeDate = DateTime.UtcNow.AddDays(4);
            const decimal firstInstallmentAmount = 400;


            // Initiates the plan with FirstChargeDate and FirstInstallmentAmount set
            // initResponse contains urls to which you should redirect your customers (eg. checkoutUrl, termsConditionsUrl, privacyPolicyUrl, learnMoreUrl)
            var initResponse = PlanApi.InstallmentPlanInitiate(new InitiateInstallmentPlanRequest()
            {
                PlanData = new PlanData
                {
                    Amount = new MoneyWithCurrencyCode(600, "USD"),
                    NumberOfInstallments = 3,
                    AutoCapture = true,
                    FirstInstallmentAmount = new MoneyWithCurrencyCode(firstInstallmentAmount, "USD"),
                    FirstChargeDate = firstChargeDate,
                },
                PaymentWizardData = new PaymentWizardData(requestedNumberOfInstallments: "2,3,4,5,6"),
                // After user successfully interacts with splitit.com they would be
                // redirected to provided Succeeded URL with InstallmentPlanNumber as
                // a parameter in GET request. It is required to continue the flow.
                RedirectUrls = new RedirectUrls
                {
                    Canceled = "http://localhost/Canceled",
                    Failed = "http://localhost/Failed",
                    Succeeded = "http://localhost/Succeeded"
                },
                BillingAddress = new AddressData
                {
                    AddressLine = "260 Madison Avenue.",
                    City = "New York",
                    State = "NY",
                    Country = "USA",
                    Zip = "10016"
                }, // TODO: set actual billing address data to pre-fill the from (optional)
                ConsumerData = new ConsumerData
                {
                    FullName = "John Smith",
                    Email = "JohnS@splitit.com",
                    PhoneNumber = "1-415-775-4848",
                    CultureName = "en-us"
                }, // TODO: set actual consumer data to pre-fill the form (optional)
            });
            // Use the T&C, PrivacyPolicy and the LearnMore urls
            // Save the Installment plan number for future use during the creation of a new plan

            if (initResponse.ResponseHeader.Succeeded ?? false)
            {
                // TODO: take the initResponse.CheckoutUrl and redirect your shopper to it
            }
            else
            {
                // TODO: show the return error from initResponse.ResponseHeader.Errors
            }

        }

        // Checks for potential fraud attempts
        // This function MUST be called after payment is processed on Splitit's end, before merchant closes the order on his end
        void VerifyPayment(string installmentPlanNumber)
        {
            var verifyResponse =
                PlanApi.InstallmentPlanVerifyPayment(
                    new VerifyPaymentRequest(installmentPlanNumber));

            // Verifies amount payed
            // TODO: please fill the value {MERCHANT_AMOUNT} from your session
            var paymentSuccessful = verifyResponse.ResponseHeader.Succeeded ?? false;
            var paymentVerified =
                (verifyResponse.IsPaid ?? false) && verifyResponse.OriginalAmountPaid == MERCHANT_AMOUNT;

            if (paymentSuccessful && paymentVerified)
            {
                // TODO: Success - close order in your system
            }
            else
            {
                // TODO: call the InstallmentPlanCancel function with the installment plan number
            }
        }
    }
}
