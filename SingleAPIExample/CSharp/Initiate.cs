using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class InitiateExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Initiate()
        {
            var initResponse = PlanApi.InstallmentPlanInitiate(new InitiateInstallmentPlanRequest()
            {
                PlanData = new PlanData
                {
                    Amount = new MoneyWithCurrencyCode(600, "USD"), NumberOfInstallments = 3, RefOrderNumber = "abc123",
                    AutoCapture = true
                },
                PaymentWizardData = new PaymentWizardData(requestedNumberOfInstallments: "2,3,4,5,6"),
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
                },
                ConsumerData = new ConsumerData
                {
                    FullName = "John Smith",
                    Email = "JohnS@splitit.com",
                    PhoneNumber = "1-415-775-4848",
                    CultureName = "en-us"
                },
            });
        }
    }
}
