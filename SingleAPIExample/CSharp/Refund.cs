using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class RefundExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Refund(string installmentPlanNumber)
        {
            var request = new RefundPlanRequest
            {
                InstallmentPlanNumber = installmentPlanNumber,
                Amount = new MoneyWithCurrencyCode(600, "USD"),
                RefundStrategy =  RefundStrategy.FutureInstallmentsLast,
            };

            var refundResponse = PlanApi.InstallmentPlanRefund(request);
        }
    }
}
