using Splitit.SDK.Client.Api;
using Splitit.SDK.Client.Model;

namespace Examples
{
    public class GetExample
    {
        InstallmentPlanApi PlanApi { get; }

        public void Get(string installmentPlanNumber)
        {
            var request = new GetInstallmentsPlanSearchCriteriaRequest
            {
                QueryCriteria = new InstallmentPlanQueryCriteria
                {
                    InstallmentPlanNumber = installmentPlanNumber,
                }
            };
            var getResponse = PlanApi.InstallmentPlanGet(request);
        }
    }
}
