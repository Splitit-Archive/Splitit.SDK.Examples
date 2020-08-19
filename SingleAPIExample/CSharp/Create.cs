using System;
using System.Collections.Generic;
using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class CreateExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Create(string installmentPlanNumber)
        {
            var createResponse = PlanApi.InstallmentPlanCreate(new CreateInstallmentPlanRequest
            {
                InstallmentPlanNumber = installmentPlanNumber,
                PlanData = new PlanData
                {
                    Amount = new MoneyWithCurrencyCode(600, "USD"),
                    NumberOfInstallments = 3,
                    RefOrderNumber = "abc123",
                    AutoCapture = true,
                    PurchaseMethod = PurchaseMethod.ECommerce,
                    FirstChargeDate = DateTime.Now,
                    FirstInstallmentAmount = new MoneyWithCurrencyCode(200, "USD"),
                    ExtendedParams = new Dictionary<string, string>
                    {
                        ["AnyParamaterKey1"] = "AnyParameterVal1",
                        ["AnyParameterKey2"] = "AnyParameterVal2",
                    },

                },
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
                PlanApprovalEvidence = new PlanApprovalEvidence(areTermsAndConditionsApproved: true),
                CreditCardDetails = new CardData
                {
                    CardNumber = "411111111111111",
                    CardCvv = "111",
                    CardHolderFullName = "John Smith",
                    CardExpMonth = "12",
                    CardExpYear = "2022",
                },
            });
        }
    }
}
