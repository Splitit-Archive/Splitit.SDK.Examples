using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Client;
using Splitit.SDK.Client.Model;

namespace Splitit.SDK.Example
{
    /// <summary>
    /// Scenario where a cc token from the previous plan is used to create a new one
    /// </summary>
    class PaymentFormWithCCToken
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

        // Retrieves the credit card token from previous splitit installment plan of a returning shopper
        // TODO get the oldInstallmentPlanNumber from your DB
        string GetCCToken(string oldInstallmentPlanNumber)
        {
            var getResponse = PlanApi.InstallmentPlanGet(new GetInstallmentsPlanSearchCriteriaRequest()
            {
                QueryCriteria =
                    new InstallmentPlanQueryCriteria(
                        installmentPlanNumber: oldInstallmentPlanNumber)
            });

            return getResponse.PlansList[0].ActiveCard.Token;
        }

        // Initiates the new plan
        string InitiateInstallmentPlan()
        {
            var initResponse = PlanApi.InstallmentPlanInitiate(new InitiateInstallmentPlanRequest()
            {
                PlanData = new PlanData
                {
                    Amount = new MoneyWithCurrencyCode(600, "USD"), NumberOfInstallments = 3, RefOrderNumber = "abc123",
                    AutoCapture = true
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
            var newPlanNumber = initResponse.InstallmentPlan.InstallmentPlanNumber;

            return newPlanNumber;
        }

        // Make a payment for the new plan with an existing card token
        // TODO: Use as a handler for the subsequent Checkout requests
        void PayWithCCToken(string newPlanNumber, string ccToken)
        {
            PlanApi.InstallmentPlanCreate(new CreateInstallmentPlanRequest
            {
                InstallmentPlanNumber = newPlanNumber,
                PlanApprovalEvidence = new PlanApprovalEvidence(areTermsAndConditionsApproved: true),
                // Use credit card from previous payment
                PaymentToken = new PaymentToken
                {
                    Token = ccToken,
                    Type = "card",
                }
            });
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
