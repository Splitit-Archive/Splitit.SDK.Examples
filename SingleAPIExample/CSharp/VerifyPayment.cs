using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class VerifyPaymentExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void VerifyPayment(string installmentPlanNumber)
        {
            var verifyResponse = PlanApi.InstallmentPlanVerifyPayment(new VerifyPaymentRequest(installmentPlanNumber));
        }
    }
}
