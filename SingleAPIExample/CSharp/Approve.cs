using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class ApproveExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Approve(string installmentPlanNumber)
        {
            var request = new ApproveInstallmentPlanRequest
            {
                InstallmentPlanNumber = installmentPlanNumber,
                AreTermsAndConditionsApproved = true,
            };

            var approveResponse = PlanApi.InstallmentPlanApprove(request);
        }
    }
}
