import splitit

username, password, api_key = (
    "username",
    "password",
    "api_key",
)

api_client = splitit.ApiClient(splitit.Configuration(username, password, api_key, sandbox=True))


def get_installment_plan(ipn):
    resp = api_client.InstallmentPlanApi.installment_plan_get(
        splitit.GetInstallmentsPlanSearchCriteriaRequest(
            splitit.InstallmentPlanQueryCriteria(
                installment_plan_number=ipn,
            )
        )
    )
    return resp
