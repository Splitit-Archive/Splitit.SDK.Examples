using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class StartInstallmentsExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void StartInstallments(string installmentPlanNumber)
        {
            var startInstallmentsResponse = PlanApi.InstallmentPlanStartInstallments(new StartInstallmentsRequest(installmentPlanNumber));
        }
    }
}
