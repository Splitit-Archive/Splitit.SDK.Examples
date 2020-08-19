using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class CancelExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Cancel(string installmentPlanNumber)
        {
            var request = new CancelInstallmentPlanRequest
            {
                InstallmentPlanNumber = installmentPlanNumber,
                RefundUnderCancelation = RefundUnderCancelation.NoRefunds,
            };

            var cancelResponse = PlanApi.InstallmentPlanCancel(request);
        }
    }
}
